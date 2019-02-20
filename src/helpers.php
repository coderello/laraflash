<?php

use Illuminate\Container\Container;

if (! function_exists('laraflash')) {
    function laraflash(...$args)
    {
        /** @var \Coderello\Laraflash\Laraflash\Laraflash $laraflash */
        $laraflash = Container::getInstance()->make('laraflash');

        if ($args) {
            return $laraflash->message(...$args);
        }

        return $laraflash;
    }
}
