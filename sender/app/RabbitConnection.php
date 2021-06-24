<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnection
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    public function __construct(
        string $host = null,
        string $port = null,
        string $user = null,
        string $password = null,
        string $vhost = null
    ) {
        $this->connection = new AMQPStreamConnection(
            $host ?? $_ENV['API_AMQP_HOST'],
            $port ?? $_ENV['API_AMQP_PORT'],
            $user ?? $_ENV['API_AMQP_USERNAME'],
            $password ?? $_ENV['API_AMQP_PASSWORD'],
            $vhost ?? $_ENV['API_AMQP_VHOST']
        );
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }
}
