<?php

namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    /**
     * @var AMQPChannel
     */
    private $channel;
    /**
     * @var Calculation
     */
    private $calculation;

    public function __construct()
    {
        $connection = (new RabbitConnection())->getConnection();
        $this->channel = $connection->channel();

        $this->channel->exchange_declare(
            $_ENV['EXCHANGE_RESULT'],
            'direct',
            false,
            false,
            false
        );

        $this->calculation = new Calculation();
    }

    public function handle(AMQPMessage $msg)
    {
        $data = $this->calculation->handle(json_decode($msg->body, true));
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, $_ENV['EXCHANGE_RESULT'], $_ENV['ROUTING_KEY_RESULT']);
    }
}
