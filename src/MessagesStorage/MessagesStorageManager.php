<?php

namespace Coderello\Laraflash\MessagesStorage;

use Illuminate\Support\Manager;

class MessagesStorageManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->app['config']['laraflash.messages_storage'];
    }

    public function createSessionDriver()
    {
        return $this->app->make(SessionMessagesStorage::class);
    }

    public function createArrayDriver()
    {
        return $this->app->make(ArrayMessagesStorage::class);
    }
}
