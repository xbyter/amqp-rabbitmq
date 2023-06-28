<?php

namespace Xbyter\Amqp\Interfaces;;

interface PackerInterface
{
    public function pack($data): string;

    public function unpack(string $data);
}
