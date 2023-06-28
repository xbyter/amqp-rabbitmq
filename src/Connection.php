<?php

namespace Xbyter\Amqp;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPLazyConnection;

/**
 * Class Connection
 *
 * @package Xbyter\Amqp
 * @mixin  AbstractConnection
 */
class Connection
{
    protected ?Channel $channel = null;

    protected AbstractConnection $connection;

    public function __construct(ConnectionConfig $config)
    {
        //使用懒加载，不在构造函数里连接RabbitMQ
        $this->connection = new AMQPLazyConnection(
            $config->host,
            $config->port,
            $config->user,
            $config->password,
            $config->vhost,
            $config->insist,
            $config->login_method,
            null,
            $config->locale,
            $config->connection_timeout,
            $config->read_write_timeout,
            $config->context,
            $config->keepalive,
            $config->heartbeat
        );
    }



    public function channel(int $channel_id = null): Channel
    {
        if (!isset($this->channel) || !$this->channel->getConnection() || !$this->connection->isConnected()) {
            $this->channel = new Channel($this->connection->channel($channel_id));
        }
        return $this->channel;
    }

    public function __call($name, $arguments)
    {
        return $this->connection->{$name}(...$arguments);
    }
}
