<?php

namespace Coderello\Laraflash\Facades;

use Coderello\Laraflash\Laraflash;
use Illuminate\Support\Facades\Facade;

class LaraflashFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Laraflash::class;
    }
}