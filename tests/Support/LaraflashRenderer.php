<?php

namespace Coderello\Laraflash\Tests\Support;

use Coderello\Laraflash\Laraflash\Laraflash;
use Coderello\Laraflash\Laraflash\LaraflashRendererContract;

class LaraflashRenderer implements LaraflashRendererContract
{
    const RESULT = 'RENDERED LARAFLASH';

    public function render(Laraflash $laraflash): string
    {
        return self::RESULT;
    }
}
