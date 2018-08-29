<?php

namespace Coderello\Laraflash\Exceptions;

class InvalidHopsAmountException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid hops amount.');
    }
}
