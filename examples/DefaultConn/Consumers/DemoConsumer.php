<?php

namespace Examples\DefaultConn\Consumers;


use Examples\DefaultConn\BaseDefaultConsumerMessage;
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
