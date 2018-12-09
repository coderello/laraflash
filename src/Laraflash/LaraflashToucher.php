<?php

namespace Coderello\Laraflash\Laraflash;

use Illuminate\Http\Request;

class LaraflashToucher implements LaraflashToucherContract
{
    public function handle(Laraflash $laraflash, Request $request)
    {
        $laraflash->touch();
    }
}
