<?php
require "../vendor/autoload.php";

$configs = require "amqp.config.php";

$consumers = $configs['consumers'];
$connections = $configs['connections'];

//创建连接管理器
$connectionManage = \Xbyter\Amqp\Examples\ConnectionManageBuilder::buildFromConnections($connections);

//创建exchange和queue并绑定他们之间的关系
$declarer = new \Xbyter\Amqp\Declarer($connectionManage);
foreach ($connections as $connName => $connConfig) {
    $declarer->setExchanges($connName, $connConfig['declarer']['exchanges'] ?? []);
    $declarer->setQueues($connName, $connConfig['declarer']['queues'] ?? []);
    $declarer->setBinds($connName, $connConfig['declarer']['binds'] ?? []);
}
$declarer->createAndBind();

//发布消息
$producer = new \Xbyter\Amqp\Producer($connectionManage);
$producer->publish(new \Xbyter\Amqp\Examples\DefaultConn\Producers\DemoProducer('消息参数1', '消息参数2'));

//消费指定消费者消息
$consumer = new \Xbyter\Amqp\Consumer($connectionManage);
$consumer->consume(new \Xbyter\Amqp\Examples\DefaultConn\Consumers\DemoConsumer());

//启动消费服务（建议使用supervisor等进程管理工具）
$consumerServer = new \Xbyter\Amqp\Examples\ConsumerServer($consumer);
$consumerServer->run($consumers);
