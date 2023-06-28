<?php
namespace Xbyter\Amqp\Enum;

class ExchangeTypeEnum
{
    public const DIRECT = 'direct';
    public const FANOUT = 'fanout';
    public const TOPIC  = 'topic';
    public const X_DELAYED_MESSAGE  = 'x-delayed-message';
}
