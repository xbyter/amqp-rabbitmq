<?php

namespace Examples\DefaultConn\Dclarer\Queues;

use Xbyter\Amqp\Declarer\QueueDeclarer;


class DemoQueue extends QueueDeclarer
{
    public const QUEUE = 'demo_queue';
}
