<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    public function handle(AMQPMessage $msg)
    {
        echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
    }
}
