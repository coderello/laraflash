<?php

namespace Coderello\Laraflash\Middleware;

use Closure;
use Illuminate\Container\Container;
use Coderello\Laraflash\Laraflash\LaraflashPreparerContract;

class HandleLaraflash
{
    protected $laraflash;

    protected $laraflashToucher;

    public function __construct(LaraflashPreparerContract $laraflashToucher)
    {
        $this->laraflash = Container::getInstance()->make('laraflash');

        $this->laraflashToucher = $laraflashToucher;
    }

    public function handle($request, Closure $next)
    {
        $this->laraflash->load();

        $this->laraflashToucher->handle($this->laraflash, $request);

        $response = $next($request);

        $this->laraflash->save();

        return $response;
    }
}
