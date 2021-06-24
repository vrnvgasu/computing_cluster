<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\RabbitConnection;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare('exchange', 'direct', false, false, false);
$channel->queue_declare('queue', false, false, false, false);
$channel->queue_bind('queue', 'exchange', 'routing_key');

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

//подписались на нашу очередь $queue_name
$channel->basic_consume(
    'queue',
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