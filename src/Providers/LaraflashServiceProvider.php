<?php

namespace Coderello\Laraflash\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Coderello\Laraflash\Laraflash\Laraflash;
use Coderello\Laraflash\Laraflash\LaraflashPreparer;
use Coderello\Laraflash\Laraflash\LaraflashRenderer;
use Coderello\Laraflash\FlashMessage\FlashMessageFactory;
use Coderello\Laraflash\Laraflash\LaraflashPreparerContract;
use Coderello\Laraflash\Laraflash\LaraflashRendererContract;
use Coderello\Laraflash\FlashMessage\ViewFlashMessageRenderer;
use Coderello\Laraflash\MessagesStorage\MessagesStorageManager;
use Coderello\Laraflash\MessagesStorage\SessionMessagesStorage;
use Coderello\Laraflash\MessagesStorage\MessagesStorageContract;
use Coderello\Laraflash\FlashMessage\FlashMessageFactoryContract;
use Coderello\Laraflash\FlashMessage\FlashMessageRendererContract;

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
        $this->registerBindings();

        $this->configure();
    }

    /**
     * Register the Laraflash bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind(MessagesStorageContract::class, SessionMessagesStorage::class);

        $this->app->bind(LaraflashRendererContract::class, LaraflashRenderer::class);

        $this->app->bind(FlashMessageRendererContract::class, ViewFlashMessageRenderer::class);

        $this->app->bind(LaraflashPreparerContract::class, LaraflashPreparer::class);

        $this->app->bind(FlashMessageFactoryContract::class, FlashMessageFactory::class);

        $this->app->singleton(MessagesStorageManager::class, function (Application $app) {
            return new MessagesStorageManager($app);
        });

        $this->app->bind(MessagesStorageContract::class, function (Application $app) {
            /** @var MessagesStorageManager $messagesStorageManager */
            $messagesStorageManager = $app->make(MessagesStorageManager::class);

            return $messagesStorageManager->driver();
        });

        $this->app->singleton('laraflash', function (Application $app) {
            return $app->make(Laraflash::class);
        });
    }

    /**
     * Setup the resource publishing groups for Laraflash.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../../resources/views' => $this->app->resourcePath('views/vendor/laraflash'),
        ], 'laraflash-views');

        $this->publishes([
            __DIR__.'/../../config/laraflash.php' => $this->app->configPath('laraflash.php'),
        ], 'laraflash-config');
    }

    /**
     * Register the Laraflash resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views/components/skins', 'laraflash_skin');
    }

    /**
     * Setup the configuration for Laraflash.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraflash.php',
            'laraflash'
        );
    }
}
