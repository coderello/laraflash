<?php

namespace Coderello\Laraflash\Laraflash;

use Illuminate\Http\Request;

interface LaraflashPreparerContract
{
    public function handle(Laraflash $laraflash, Request $request);
}
