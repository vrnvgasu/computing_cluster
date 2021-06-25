<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\Factory;
use App\RabbitConnection;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpAmqpLib\Message\AMQPMessage;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare(
    $_ENV['EXCHANGE_INIT'],
    'direct',
    false,
    false,
    false
);

$taskCount = implode(' ', array_slice($argv, 1));
if (empty($taskCount)) {
    $taskCount = 5;
}

$data = [];

$log = new Logger('send_task');
$log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/send_task.log', Logger::INFO));

/** @var \App\Task $task */
foreach ((new Factory())->generateTasks((int)$taskCount) as $task) {
    $data = [
        'id' => $task->getId(),
        'matrix' => $task->dimension->vars,
        'hurwitz' => [
            'var1' => $task->hurwitz->var1,
            'var2' => $task->hurwitz->var2,
        ],
        'bayes' => $task->bayes->probabilities,
    ];

    $data = json_encode($data);
    $msg = new AMQPMessage($data);

    $channel->basic_publish($msg, $_ENV['EXCHANGE_INIT'], $_ENV['ROUTING_KEY_INIT']);

    $log->info($task->getId());
    echo ' [x] Sent ', $task->getId(), "\n";
}

$channel->close();
$connection->close();