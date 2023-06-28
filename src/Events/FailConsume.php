<?php

namespace Xbyter\Amqp\Events;

use Xbyter\Amqp\Interfaces\ConsumerMessageInterface;

class FailConsume extends BaseConsumeEvent
{
    /**
     * @var \Throwable
     */
    protected \Throwable $throwable;

    public function __construct(ConsumerMessageInterface $message, \Throwable $throwable)
    {
        parent::__construct($message);
        $this->throwable = $throwable;
    }

    public function getThrowable(): \Throwable
    {
        return $this->throwable;
    }
}
