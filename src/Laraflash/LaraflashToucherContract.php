<?php

namespace Coderello\Laraflash\Laraflash;

use Illuminate\Http\Request;

interface LaraflashToucherContract
{
    public function handle(Laraflash $laraflash, Request $request);
}
