<?php

namespace Xbyter\Amqp;


class ConnectionConfig
{
    public string $host = 'localhost';
    public int $port = 5672;
    public string $user = 'guest';
    public string $password = 'guest';
    public string $vhost = '/';
    public bool $insist = false;
    public string $login_method = 'AMQPLAIN';
    public string $locale = 'en_US';
    public float $connection_timeout = 3.0;
    public float $read_write_timeout = 6.0;
    public ?array $context = null;
    public bool $keepalive = false;
    public int $heartbeat = 3;
}
