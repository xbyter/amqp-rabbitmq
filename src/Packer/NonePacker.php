<?php
namespace Xbyter\Amqp\Packer;

use Xbyter\Amqp\Interfaces\PackerInterface;


class NonePacker implements PackerInterface
{
    /**
     * @throws \JsonException
     */
    public function pack($data): string
    {
        return $data;
    }

    /**
     * @throws \JsonException
     */
    public function unpack(string $data)
    {
        return $data;
    }
}

