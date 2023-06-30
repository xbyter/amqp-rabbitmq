<?php

namespace Xbyter\Amqp\Examples\DefaultConn;


use Xbyter\Amqp\BaseConsumerMessage;
use Xbyter\Amqp\Enum\ConsumeResultEnum;

abstract class BaseDefaultConsumerMessage extends BaseConsumerMessage
{
    /** @var string 所属连接 */
    protected string $conn = 'default';

    protected array $qos = [
        //消息预取数量,越高性能越好但可能导致消息积压到一个进程里导致其他进程空着
        'prefetch_count' => 10,
        'prefetch_size'  => null,
        'global'         => false,
    ];

    public function consume(string $body): string
    {
        try {
            $data = $this->unserialize($body);
            return $this->handle(...$data);
        } catch (\Throwable $e) {
            $this->log(sprintf('run queue error: %s', [$e->getMessage()]));
        }

        return ConsumeResultEnum::REJECT_DROP;
    }


    protected function log(string $content):void
    {
        //write log
    }
}
