<?php

namespace Xbyter\Amqp\Interfaces;


interface ConsumerMessageInterface extends MessageInterface
{

    /**
     * @return string
     */
    public function getQueue(): string;

    /**
     * @return array|int[]
     */
    public function getQos(): array;

    public function consume(string $body): string;
}
