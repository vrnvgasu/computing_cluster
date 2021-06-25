<?php
require_once __DIR__ . '/../../../bin/app.php';

use App\RabbitConnection;

$connection = (new RabbitConnection())->getConnection();
$channel = $connection->channel();

$channel->exchange_declare($_ENV['EXCHANGE_RESULT'], 'direct', false, false, false);
$channel->queue_declare($_ENV['QUEUE_RESULT'], false, false, false, false);
$channel->queue_bind($_ENV['QUEUE_RESULT'], $_ENV['EXCHANGE_RESULT'], $_ENV['ROUTING_KEY_RESULT']);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

//подписались на нашу очередь $queue_name
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