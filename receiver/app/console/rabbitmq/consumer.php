<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\Consumer;
use App\RabbitConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare($_ENV['EXCHANGE_INIT'], 'direct', false, false, false);
$channel->queue_declare($_ENV['QUEUE_INIT'], false, false, false, false);
$channel->queue_bind($_ENV['QUEUE_INIT'], $_ENV['EXCHANGE_INIT'], $_ENV['ROUTING_KEY_INIT']);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$consumer = new Consumer();
$channel->basic_consume(
    $_ENV['QUEUE_INIT'],
    '',
    false,
    true,
    false,
    false,
    function (AMQPMessage $msg) use ($consumer): void {
        $consumer->handle($msg);
    }
);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();