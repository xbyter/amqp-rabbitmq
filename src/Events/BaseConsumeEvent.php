<?php

namespace Xbyter\Amqp\Events;

use Xbyter\Amqp\Interfaces\ConsumerMessageInterface;

class BaseConsumeEvent
{

    protected ConsumerMessageInterface $message;

    public function __construct(ConsumerMessageInterface $message)
    {
        $this->message = $message;
    }

    public function getMessage(): ConsumerMessageInterface
    {
        return $this->message;
    }
}
