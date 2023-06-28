<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Declarer\ExchangeDeclarer;
use Xbyter\Amqp\Declarer\QueueDeclarer;

class Declarer
{
    protected ConnectionManage $connectionManage;

    /** @var string[][] 定义的交换器集合 */
    protected array $exchanges = [];

    /** @var string[][] 定义的队列集合 */
    protected array $queues = [];

    /**
     * @var array[] 定义的绑定关系
     * @example [[Exchange::class, Queue::class, ['routing_key1', 'routing_key2']]
     */
    protected array $binds = [];

    public function __construct(ConnectionManage $connectionManage)
    {
        $this->connectionManage = $connectionManage;
    }


    /**
     * @param string[] $exchanges
     */
    public function setExchanges(string $conn, array $exchanges): self
    {
        $this->exchanges[$conn] = $exchanges;
        return $this;
    }

    /**
     * @return \string[][]
     */
    public function getExchanges(): array
    {
        return $this->exchanges;
    }

    /**
     * @param string[] $queues
     */
    public function setQueues(string $conn, array $queues): self
    {
        $this->queues[$conn] = $queues;
        return $this;
    }

    /**
     * @return \string[][]
     */
    public function getQueues(): array
    {
        return $this->queues;
    }

    /**
     * @param array[] $binds
     */
    public function setBinds(string $conn, array $binds): self
    {
        $this->binds[$conn] = $binds;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getBinds(): array
    {
        return $this->binds;
    }


    public function createExchange(string $conn, ExchangeDeclarer $exchangeDeclarer): void
    {
        $connection = $this->connectionManage->getConnection($conn);
        $channel = $connection->channel();

        $channel->exchange_declare($exchangeDeclarer->getExchange(), $exchangeDeclarer->getType(), $exchangeDeclarer->isPassive(), $exchangeDeclarer->isDurable(), $exchangeDeclarer->isAutoDelete(), $exchangeDeclarer->isInternal(), $exchangeDeclarer->isNowait(), $exchangeDeclarer->getArguments(), $exchangeDeclarer->getTicket());

        $channel->close();
        $connection->close();
    }

    public function createQueue(string $conn, QueueDeclarer $queueDeclarer): void
    {
        $connection = $this->connectionManage->getConnection($conn);
        $channel = $connection->channel();

        $channel->queue_declare($queueDeclarer->getQueue(), $queueDeclarer->isPassive(), $queueDeclarer->isDurable(), $queueDeclarer->isExclusive(), $queueDeclarer->isAutoDelete(), $queueDeclarer->isNowait(), $queueDeclarer->getArguments(), $queueDeclarer->getTicket());

        $channel->close();
        $connection->close();
    }

    public function bindQueue(string $conn, ExchangeDeclarer $exchange, QueueDeclarer $queue, array $routingKeys): void
    {
        $connection = $this->connectionManage->getConnection($conn);
        $channel = $connection->channel();

        foreach ($routingKeys as $routingKey) {
            $channel->queue_bind($queue->getQueue(), $exchange->getExchange(), $routingKey);
        }
        $channel->close();
        $connection->close();
    }

    public function createExchanges(): void
    {
        foreach ($this->getExchanges() as $conn => $exchanges) {
            /** @var ExchangeDeclarer $exchange */
            foreach ($exchanges as $exchange) {
                $this->createExchange($conn, new $exchange);
            }
        }
    }

    public function createQueues(): void
    {
        foreach ($this->getQueues() as $conn => $queues) {
            /** @var QueueDeclarer $queue */
            foreach ($queues as $queue) {
                $this->createQueue($conn, new $queue);
            }
        }
    }

    public function bindQueues(): void
    {
        foreach ($this->getBinds() as $conn => $params) {
            foreach ($params as $param) {
                [$exchange, $queue, $routingKeys] = $param;
                $this->bindQueue($conn, new $exchange, new $queue, $routingKeys);
            }
        }
    }

    public function createAndBind(): void
    {
        $this->createExchanges();
        $this->createQueues();
        $this->bindQueues();
    }
}
