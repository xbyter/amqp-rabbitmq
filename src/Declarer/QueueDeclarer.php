<?php

namespace Xbyter\Amqp\Declarer;

class QueueDeclarer extends BaseDeclarer
{
    public const QUEUE = '';

    protected bool $exclusive = false;


    public function getQueue(): string
    {
        return static::QUEUE;
    }


    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    public function setExclusive(bool $exclusive): self
    {
        $this->exclusive = $exclusive;
        return $this;
    }
}
