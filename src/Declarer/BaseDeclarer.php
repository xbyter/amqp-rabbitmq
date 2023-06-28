<?php

namespace Xbyter\Amqp\Declarer;

use PhpAmqpLib\Wire\AMQPTable;

abstract class BaseDeclarer
{
    /**
     * @var bool
     */
    protected bool $passive = false;

    /**
     * @var bool
     */
    protected bool $durable = true;

    /**
     * @var bool
     */
    protected bool $autoDelete = false;

    /**
     * @var bool
     */
    protected bool $nowait = false;

    /**
     * @var AMQPTable|null
     */
    protected ?AMQPTable $arguments = null;

    /**
     * @var null|int
     */
    protected ?int $ticket = null;

    public function isPassive(): bool
    {
        return $this->passive;
    }

    public function setPassive(bool $passive): self
    {
        $this->passive = $passive;
        return $this;
    }

    public function isDurable(): bool
    {
        return $this->durable;
    }

    public function setDurable(bool $durable): self
    {
        $this->durable = $durable;
        return $this;
    }

    public function isAutoDelete(): bool
    {
        return $this->autoDelete;
    }

    public function setAutoDelete(bool $autoDelete): self
    {
        $this->autoDelete = $autoDelete;
        return $this;
    }

    public function isNowait(): bool
    {
        return $this->nowait;
    }

    public function setNowait(bool $nowait): self
    {
        $this->nowait = $nowait;
        return $this;
    }

    /**
     * @return AMQPTable|null
     */
    public function getArguments(): ?AMQPTable
    {
        return $this->arguments;
    }

    /**
     * @param AMQPTable $arguments
     * @return \Xbyter\Amqp\Declarer\BaseDeclarer
     */
    public function setArguments(AMQPTable $arguments): self
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return null|int
     */
    public function getTicket(): ?int
    {
        return $this->ticket;
    }

    /**
     * @param null|int $ticket
     * @return \Xbyter\Amqp\Declarer\BaseDeclarer
     */
    public function setTicket(?int $ticket): self
    {
        $this->ticket = $ticket;
        return $this;
    }
}
