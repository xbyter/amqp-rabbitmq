<?php

namespace Xbyter\Amqp;

use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class Connection
 *
 * @package Xbyter\Amqp
 * @mixin  AMQPChannel
 */
class Channel
{
    protected AMQPChannel $channel;

    /**
     * 是否有任务在里面，无任务会sleep一段时间
     * @var bool
     */
    protected bool $hasMessage = false;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return bool
     */
    public function hasMessage(): bool
    {
        return $this->hasMessage;
    }


    /**
     * @param bool $hasMessage
     */
    public function setHasMessage(bool $hasMessage): void
    {
        $this->hasMessage = $hasMessage;
    }

    public function __call($name, $arguments)
    {
        return $this->channel->{$name}(...$arguments);
    }
}
