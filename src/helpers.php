<?php

use Coderello\Laraflash\Laraflash;

if (! function_exists('laraflash')) {
    /**
     * @return Laraflash
     */
    function laraflash(): Laraflash
    {
        return app()->make(Laraflash::class);
    }
}
