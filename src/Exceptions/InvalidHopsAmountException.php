<?php

namespace Coderello\Laraflash\Exceptions;

class InvalidHopsAmountException extends InvalidArgumentException
{
    public function __construct()
    {
        $this->message = 'Invalid hops amount.';
    }
}
