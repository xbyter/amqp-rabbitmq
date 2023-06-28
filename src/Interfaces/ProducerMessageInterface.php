<?php

namespace Xbyter\Amqp\Interfaces;;

interface ProducerMessageInterface extends MessageInterface
{
    /**
     * 获得原始数据
     * @return array
     */
    public function getData(): array;


    /**
     * 获取序列化之后的请求体
     * @return string
     */
    public function getBody(): string;

    /**
     * @return array
     */
    public function getProperties(): array;

    /**
     * @return string
     */
    public function getRoutingKey(): string;

    /**
     * @return string
     */
    public function getExchange(): string;
}
