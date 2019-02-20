<?php

namespace Coderello\Laraflash\Laraflash;

use Illuminate\Http\Request;

class LaraflashPreparer implements LaraflashPreparerContract
{
    public function handle(Laraflash $laraflash, Request $request)
    {
        $laraflash->touch();
    }
}
