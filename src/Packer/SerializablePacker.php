<?php
namespace Xbyter\Amqp\Packer;

use Xbyter\Amqp\Interfaces\PackerInterface;


class SerializablePacker implements PackerInterface
{

    public function pack($data): string
    {
        return serialize($data);
    }


    public function unpack(string $data)
    {
        return unserialize($data);
    }
}

