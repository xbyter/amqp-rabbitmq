<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Interfaces\ProducerMessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Producer
{

    private ConnectionManage $connectionManage;

    public function __construct(ConnectionManage $connectionManage)
    {
        $this->connectionManage = $connectionManage;
    }

    /**
     * 发布消息
     *
     * @param \Xbyter\Amqp\Interfaces\ProducerMessageInterface $producerMessage
     * @param bool $confirm 确认模式可以保证消息是否达到Broker端
     * @param int $timeout
     * @return bool
     * @throws \Exception
     */
    public function publish(ProducerMessageInterface $producerMessage, bool $confirm = false, int $timeout = 5): bool
    {
        $result = false;
        $connection = $this->connectionManage->getConnection($producerMessage->getConn());
        $channel = $connection->channel();
        if ($confirm) {
            $channel->confirm_select();
            $channel->set_ack_handler(function () use (&$result) {
                $result = true;
            });
        }

        $data = $producerMessage->getBody();
        $message = new AMQPMessage($data, $producerMessage->getProperties());

        try {
            $channel->basic_publish($message, $producerMessage->getExchange(), $producerMessage->getRoutingKey());
            $channel->wait_for_pending_acks_returns($timeout);
        } finally {
            $channel->close();
            $connection->close();
        }

        return $confirm ? $result : true;
    }


}
