<?php

namespace Examples\DefaultConn\Dclarer\Exchanges;

use Xbyter\Amqp\Declarer\ExchangeDeclarer;
use Xbyter\Amqp\Enum\ExchangeTypeEnum;


class DemoExchange extends ExchangeDeclarer
{
    protected string $type = ExchangeTypeEnum::TOPIC;

    /** @var string 所属交换机 */
    public const EXCHANGE = 'demo.topic';
}
