<?php
namespace Examples;

class ConnectionManageBuilder
{
    public static function buildFromConnections(array $connections)
    {
        $connectionManage = new \Xbyter\Amqp\ConnectionManage();
        foreach ($connections as $connName => $connConfig) {
            $connectionConfig = new \Xbyter\Amqp\ConnectionConfig();
            $connectionConfig->host = $connConfig['host'];
            $connectionConfig->port = $connConfig['port'];
            $connectionConfig->user = $connConfig['user'];
            $connectionConfig->password = $connConfig['password'];
            $connectionConfig->vhost = $connConfig['vhost'];
            $connectionConfig->insist = $connConfig['insist'];
            $connectionConfig->login_method = $connConfig['login_method'];
            $connectionConfig->locale = $connConfig['locale'];
            $connectionConfig->connection_timeout = $connConfig['connection_timeout'];
            $connectionConfig->read_write_timeout = $connConfig['read_write_timeout'];
            $connectionConfig->context = $connConfig['context'];
            $connectionConfig->keepalive = $connConfig['keepalive'];
            $connectionConfig->heartbeat = $connConfig['heartbeat'];

            $connectionManage->addConnection($connName, $connectionConfig);
        }
        return $connectionManage;
    }
}
