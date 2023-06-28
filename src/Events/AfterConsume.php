<?php

namespace Xbyter\Amqp\Events;


use Xbyter\Amqp\Interfaces\ConsumerMessageInterface;

class AfterConsume extends BaseConsumeEvent
{
    protected $result;

    public function __construct(ConsumerMessageInterface $message, string $result)
    {
        parent::__construct($message);
        $this->result = $result;
    }

    public function getResult(): string
    {
        return $this->result;
    }
}
