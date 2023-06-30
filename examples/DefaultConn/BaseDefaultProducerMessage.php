<?php

namespace Xbyter\Amqp\Examples\DefaultConn;


use Xbyter\Amqp\BaseProducerMessage;

abstract class BaseDefaultProducerMessage extends BaseProducerMessage
{
    /** @var string 所属连接 */
    protected string $conn = 'default';
}
