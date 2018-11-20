<?php

namespace Coderello\Laraflash\Middleware;

use Closure;
use Illuminate\Http\Request;
use Coderello\Laraflash\Laraflash;

class HandleLaraflash
{
    public function handle($request, Closure $next)
    {
        /** @var Laraflash $laraflash */
        $laraflash = app(Laraflash::class);

        $laraflash->load();

        if ($this->shouldTouch($request)) {
            $laraflash->touch();
        }

        $response = $next($request);

        $laraflash->save();

        return $response;
    }

    public function shouldTouch(Request $request): bool
    {
        return true;
    }
}
