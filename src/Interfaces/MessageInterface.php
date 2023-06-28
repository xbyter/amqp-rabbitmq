<?php

namespace Xbyter\Amqp\Interfaces;

interface MessageInterface
{
    /**
     * 获取连接器
     * @return string
     */
    /**
     * @return string
     */
    public function getConn(): string;


    /**
     * @return string
     */
    public function getPacker(): string;
}
