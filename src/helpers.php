<?php

if (! function_exists('laraflash')) {
    function laraflash()
    {
        /** @var \Coderello\Laraflash\Laraflash\Laraflash $laraflash */
        $laraflash = app('laraflash');

        if (func_num_args()) {
            return $laraflash->message(...func_get_args());
        }

        return $laraflash;
    }
}
