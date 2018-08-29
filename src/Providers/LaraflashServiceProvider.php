<?php

namespace Coderello\Laraflash\Providers;

use Coderello\Laraflash\FlashMessagesBag;
use Coderello\Laraflash\FlashMessagesBagPreparer;
use Coderello\Laraflash\FlashMessagesBagResolver;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;

class LaraflashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FlashMessagesBag::class, function () {
            return (new FlashMessagesBagResolver(
                $this->app->make(Session::class),
                'flash_messages_bag'
            ))->bag();
        });

        $this->app->resolving(FlashMessagesBag::class, function (FlashMessagesBag $bag) {
            (new FlashMessagesBagPreparer($bag))->prepare();
        });
    }
}
