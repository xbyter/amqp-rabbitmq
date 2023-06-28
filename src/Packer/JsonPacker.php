<?php
namespace Xbyter\Amqp\Packer;

use Xbyter\Amqp\Interfaces\PackerInterface;

class JsonPacker implements PackerInterface
{
    /**
     * @throws \JsonException
     */
    public function pack($data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @throws \JsonException
     */
    public function unpack(string $data)
    {
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}

