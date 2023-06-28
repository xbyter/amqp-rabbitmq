<?php

return [
    'connections' => [
        'default' => [
            'host'               => 'localhost',
            'port'               => 5672,
            'user'               => 'guest',
            'password'           => 'guest',
            'vhost'              => '/',
            'insist'             => false,
            'login_method'       => 'AMQPLAIN',
            'locale'             => 'en_US',
            'connection_timeout' => 3.0,
            'read_write_timeout' => 6.0,
            'context'            => null,
            'keepalive'          => false,
            'heartbeat'          => 3,
            'close_on_destruct'  => false,
            'declarer'           => [
                'exchanges' => [
                    \Examples\DefaultConn\Dclarer\Exchanges\DemoExchange::class,
                ],
                'queues'    => [
                    \Examples\DefaultConn\Dclarer\Queues\DemoQueue::class,
                ],
                'binds'     => [
                    [
                        \Examples\DefaultConn\Dclarer\Exchanges\DemoExchange::class,
                        \Examples\DefaultConn\Dclarer\Queues\DemoQueue::class,
                        //routing keys
                        [\Examples\DefaultConn\Producers\DemoProducer::ROUTING_KEY],
                    ],
                ],
            ],
        ],
    ],
    //用于启动消费
    'consumers'   => [
        \Examples\DefaultConn\Consumers\DemoConsumer::class,
    ],
];
