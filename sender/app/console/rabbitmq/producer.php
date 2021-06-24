<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\Factory;
use App\RabbitConnection;
use PhpAmqpLib\Message\AMQPMessage;
var_dump(2);

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare(
    'exchange',
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

/** @var \App\Task $task */
foreach ((new Factory())->generateTasks((int)$taskCount) as $task) {
    $data[] = [
        'id' => $task->getId(),
        'dimension' => $task->dimension->n,
        'hurwitz' => [
            'var1' => $task->hurwitz->var1,
            'var2' => $task->hurwitz->var2,
        ],
        'bayes' => $task->bayes->probabilities,
    ];
}

$data = json_encode($data);
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'exchange', 'routing_key');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();