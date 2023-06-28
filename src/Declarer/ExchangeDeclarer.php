<?php

namespace Xbyter\Amqp\Declarer;

class ExchangeDeclarer extends BaseDeclarer
{
    /** @var string 所属交换机 */
    public const EXCHANGE = '';

    protected string $type;

    protected bool $internal = false;

    public function getExchange(): string
    {
        return static::EXCHANGE;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function isInternal(): bool
    {
        return $this->internal;
    }

    public function setInternal(bool $internal): self
    {
        $this->internal = $internal;
        return $this;
    }
}
