<?php

namespace Coderello\Laraflash\Providers;

use Coderello\Laraflash\MessagesStorage\MessagesStorage;
use Coderello\Laraflash\MessagesStorage\SessionMessagesStorage;
use Coderello\Laraflash\Laraflash;
use Illuminate\Foundation\Application;
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
        $this->registerResources();

        $this->offerPublishing();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessagesStorage::class, SessionMessagesStorage::class);

        $this->app->singleton('laraflash', function (Application $app) {
            return $app->make(Laraflash::class);
        });

        $this->configure();
    }

    /**
     * Setup the resource publishing groups for Laraflash.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../../resources/views' => $this->app->resourcePath('views/vendor/laraflash'),
        ], 'laraflash-views');

        $this->publishes([
            __DIR__ . '/../../config/laraflash.php' => $this->app->configPath('laraflash.php'),
        ], 'laraflash-config');
    }

    /**
     * Register the Laraflash resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/components/skins', 'laraflash_skin');
    }

    /**
     * Setup the configuration for Horizon.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laraflash.php',
            'laraflash'
        );
    }
}
