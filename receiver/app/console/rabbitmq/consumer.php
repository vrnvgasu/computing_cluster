<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\Consumer;
use App\RabbitConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare('exchange', 'direct', false, false, false);
$channel->queue_declare('worker', false, false, false, false);
$channel->queue_bind('worker', 'exchange', 'routing_key');

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$consumer = new Consumer();
$channel->basic_consume(
    'worker',
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