<?php

namespace Xbyter\Amqp\Enum;

class DeliveryModeEnum
{
    /** @var int 内存 */
    public const MEMORY = 1;

    /** @var int 持久化 */
    public const PERSISTENT = 2;
}
