<?php

namespace Coderello\Laraflash\Exceptions;

class InvalidDelayException extends InvalidArgumentException
{
    public function __construct()
    {
        $this->message = 'Invalid delay.';
    }
}
