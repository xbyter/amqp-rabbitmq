<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Enum\ConsumeResultEnum;
use Xbyter\Amqp\Interfaces\ConsumerMessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{

    private ConnectionManage $connectionManage;

    public function __construct(ConnectionManage $connectionManage)
    {
        $this->connectionManage = $connectionManage;
    }


    /**
     * 消费消息
     *
     * @param \Xbyter\Amqp\Interfaces\ConsumerMessageInterface $consumerMessage
     * @return void
     * @throws \ErrorException
     */
    public function consume(ConsumerMessageInterface $consumerMessage): void
    {
        try {
            $channel = $this->buildConsumeChannel($consumerMessage);
            $connection = $channel->getConnection();

            $channel->consume();
        } finally {
            isset($channel) && $channel->close();
            isset($connection) && $connection->close();
        }
    }

    /**
     * @param \Xbyter\Amqp\Interfaces\ConsumerMessageInterface $consumerMessage
     * @return \Xbyter\Amqp\Channel
     * @throws \Exception
     */
    public function buildConsumeChannel(ConsumerMessageInterface $consumerMessage): Channel
    {
        $connection = $this->connectionManage->getConnection($consumerMessage->getConn());
        $channel = $connection->channel();

        $qos = $consumerMessage->getQos();
        if ($qos) {
            $size = $qos['prefetch_size'] ?? null;
            $count = $qos['prefetch_count'] ?? null;
            $global = $qos['global'] ?? null;
            $channel->basic_qos($size, $count, $global);
        }

        $channel->setHasMessage(false);
        $channel->basic_consume($consumerMessage->getQueue(), '', false, false, false, false, function (
            AMQPMessage $message
        ) use ($consumerMessage, $channel) {
            $channel->setHasMessage(true);
            $this->consumeCallback($consumerMessage, $message);
        });

        return $channel;
    }

    protected function consumeCallback(ConsumerMessageInterface $consumerMessage, AMQPMessage $message): void
    {
        try {
            //event(new BeforeConsume($consumerMessage));
            $result = $consumerMessage->consume($message->getBody());
            //event(new AfterConsume($consumerMessage, $result));
        } catch (\Throwable $exception) {
            //event(new FailConsume($consumerMessage, $exception));
            $result = ConsumeResultEnum::REJECT_DROP;
        }

        if ($result === ConsumeResultEnum::ACK) {
            $message->ack();
            return;
        }


        if ($result === ConsumeResultEnum::REJECT_REQUEUE) {
            $message->reject(true);
            return;
        }

        $message->reject(false);
    }
}
