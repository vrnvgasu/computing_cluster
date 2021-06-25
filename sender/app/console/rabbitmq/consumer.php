<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\RabbitConnection;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpAmqpLib\Message\AMQPMessage;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare($_ENV['EXCHANGE_RESULT'], 'direct', false, false, false);
$channel->queue_declare($_ENV['QUEUE_RESULT'], false, false, false, false);
$channel->queue_bind($_ENV['QUEUE_RESULT'], $_ENV['EXCHANGE_RESULT'], $_ENV['ROUTING_KEY_RESULT']);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function (AMQPMessage $msg) {
    $result = json_decode($msg->body, true);
    $log = new Logger('get_result');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/get_result.log', Logger::INFO));
    $log->info($result['id']);
    echo ' [x] ', $result['id'], "\n";
};

$channel->basic_consume(
    $_ENV['QUEUE_RESULT'],
    '',
    false,
    true,
    false,
    false,
    $callback
);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();