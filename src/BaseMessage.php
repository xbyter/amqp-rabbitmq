<?php

namespace Xbyter\Amqp;

use Xbyter\Amqp\Interfaces\MessageInterface;
use Xbyter\Amqp\Packer\SerializablePacker;

abstract class BaseMessage implements MessageInterface
{
    /** @var string 所属连接 */
    protected string $conn = 'default';


    /** @var string 使用哪个序列化工具 */
    protected string $packer = SerializablePacker::class;


    /**
     * 获取连接器
     * @return string
     */
    /**
     * @return string
     */
    public function getConn(): string
    {
        return $this->conn;
    }


    /**
     * @return string
     */
    public function getPacker(): string
    {
        return $this->packer;
    }
}
