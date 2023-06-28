<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Enum\DeliveryModeEnum;
use Xbyter\Amqp\Interfaces\ProducerMessageInterface;

abstract class BaseProducerMessage extends BaseMessage implements ProducerMessageInterface
{
    /** @var string 所属交换机 */
    public const EXCHANGE = '';

    /** @var string 路由键 */
    public const ROUTING_KEY = '';

    protected array $data = [];

    /** @var array AMQPMessage->properties */
    protected array $properties = [
        'content_type'  => 'text/plain',
        'delivery_mode' => DeliveryModeEnum::PERSISTENT,
    ];

    public function __construct(...$args)
    {
        $this->data = $args;
    }

    /**
     * 获得原始数据
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }


    /**
     * 获取序列化之后的请求体
     * @return string
     */
    public function getBody(): string
    {
        /** @var \Xbyter\Amqp\Interfaces\PackerInterface $packer */
        $packer = $this->getPacker();
        $packer = new $packer();
        return $packer->pack($this->data);
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return static::ROUTING_KEY;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return static::EXCHANGE;
    }
}
