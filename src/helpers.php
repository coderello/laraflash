<?php

use Coderello\Laraflash\Contracts\FlashMessagesBag;

if (! function_exists('laraflash')) {
    /**
     * @return FlashMessagesBag
     */
    function laraflash(): FlashMessagesBag
    {
        return app('laraflash.bag');
    }
}
