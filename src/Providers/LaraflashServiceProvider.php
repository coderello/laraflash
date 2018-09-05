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
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laraflash');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/laraflash'),
        ], 'laraflash-views');

        $this->publishes([
            __DIR__.'/../../config/laraflash.php' => config_path('laraflash.php')
        ], 'laraflash-config');
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

        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraflash.php', 'laraflash'
        );
    }
}
