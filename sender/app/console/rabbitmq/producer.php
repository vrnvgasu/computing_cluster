<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../../../../.env')) {
    (new Dotenv())->load(__DIR__ . '/../../../../.env');
}

$connection = new AMQPStreamConnection(
    $_ENV['API_AMQP_HOST'],
    $_ENV['API_AMQP_PORT'],
    $_ENV['API_AMQP_USERNAME'],
    $_ENV['API_AMQP_PASSWORD'],
    $_ENV['API_AMQP_VHOST']
);
$channel = $connection->channel();

$channel->exchange_declare(
    'exchange',
    'direct',
    false,
    false,
    false
);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'exchange', 'routing_key');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();