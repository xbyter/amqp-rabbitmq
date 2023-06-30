<?php

namespace Xbyter\Amqp\Examples\DefaultConn\Consumers;


use Xbyter\Amqp\Examples\DefaultConn\BaseDefaultConsumerMessage;
use Xbyter\Amqp\Enum\ConsumeResultEnum;


class DemoConsumer extends BaseDefaultConsumerMessage
{
    public const QUEUE = 'demo_queue';

    protected function handle(string $arg1, string $arg2)
    {
        var_dump($arg1, $arg2);
        return ConsumeResultEnum::ACK;
    }
}
