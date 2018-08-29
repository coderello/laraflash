<?php

namespace Coderello\Laraflash\Exceptions;

class InvalidDelayException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid delay.');
    }
}
