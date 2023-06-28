<?php

namespace Xbyter\Amqp\Enum;


class ConsumeResultEnum
{
    /** @var string 确认消息 */
    public const ACK = 'ack';

    /** @var string 拒绝消息(跟reject功能重复，nack多了个批量的参数，暂时无需批量) */
    //public const NACK = 'nack';

    /** @var string 拒绝消息并重新入列 */
    public const REJECT_REQUEUE = 'reject_requeue';

    /** @var string 拒绝并删除消息 */
    public const REJECT_DROP = 'reject_drop';
}
