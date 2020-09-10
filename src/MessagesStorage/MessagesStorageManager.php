<?php

namespace Coderello\Laraflash\MessagesStorage;

use Illuminate\Support\Manager;

class MessagesStorageManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->container['config']['laraflash.messages_storage'];
    }

    public function createSessionDriver()
    {
        return $this->container->make(SessionMessagesStorage::class);
    }

    public function createArrayDriver()
    {
        return $this->container->make(ArrayMessagesStorage::class);
    }
}
