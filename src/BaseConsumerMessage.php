<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Enum\ConsumeResultEnum;
use Xbyter\Amqp\Interfaces\ConsumerMessageInterface;

abstract class BaseConsumerMessage extends BaseMessage implements ConsumerMessageInterface
{
    /**
     * @var string
     */
    public const QUEUE = '';

    protected array $qos = [
        //消息预取数量,越高性能越好但可能导致消息积压到一个进程里导致其他进程空着
        'prefetch_count' => 1,
        'prefetch_size'  => null,
        'global'         => false,
    ];


    /**
     * @return string
     */
    public function getQueue(): string
    {
        return static::QUEUE;
    }

    /**
     * @return array|int[]
     */
    public function getQos(): array
    {
        return $this->qos;
    }

    public function consume(string $body): string
    {
        $this->unserialize($body);
        return ConsumeResultEnum::ACK;
    }


    /**
     * 反序列化数据
     * @param string $body
     * @return mixed
     */
    protected function unserialize(string $body)
    {
        /** @var \Xbyter\Amqp\Interfaces\PackerInterface $packer */
        $packer = $this->getPacker();
        $packer = new $packer();
        return $packer->unpack($body);
    }
}
