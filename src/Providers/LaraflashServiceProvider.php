<?php

namespace Coderello\Laraflash\Providers;

use Coderello\Laraflash\FlashMessage;
use Coderello\Laraflash\FlashMessagesBag;
use Coderello\Laraflash\FlashMessagesBagResolver;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;
use Coderello\Laraflash\Contracts\FlashMessage as FlashMessageContract;
use Coderello\Laraflash\Contracts\FlashMessagesBag as FlashMessagesBagContract;
use Coderello\Laraflash\Contracts\FlashMessagesBagResolver as FlashMessagesBagResolverContract;

class LaraflashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/components/skins', 'laraflash_skin');

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
        $this->app->bind(FlashMessagesBagContract::class, FlashMessagesBag::class);
        $this->app->bind(FlashMessageContract::class, FlashMessage::class);
        $this->app->bind(FlashMessagesBagResolverContract::class, FlashMessagesBagResolver::class);

        $this->app->singleton('laraflash.bag', function () {
            return $this->app->make(FlashMessagesBagResolverContract::class, [
                'session' => $this->app->make(Session::class),
                'sessionKey' => 'flash_messages_bag',
            ])->bag();
        });

        $this->app->resolving('laraflash.bag', function (FlashMessagesBagContract $bag) {
            $bag->prepare();
        });

        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraflash.php',
            'laraflash'
        );
    }
}
