<?php

namespace Xbyter\Amqp\Examples\DefaultConn\Producers;


use Xbyter\Amqp\Examples\DefaultConn\BaseDefaultProducerMessage;

class DemoProducer extends BaseDefaultProducerMessage
{
    /** @var string 所属交换机 */
    public const EXCHANGE = 'demo.topic';

    public const ROUTING_KEY = 'demo.order.shipped';
}
