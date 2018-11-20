<?php

namespace Coderello\Laraflash\Facades;

use Illuminate\Support\Facades\Facade;

class Laraflash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraflash';
    }
}
