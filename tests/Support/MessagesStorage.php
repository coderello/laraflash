<?php

namespace Coderello\Laraflash\Tests\Support;

use Coderello\Laraflash\MessagesStorage\MessagesStorageContract;

class MessagesStorage implements MessagesStorageContract
{
    public $messages = [];

    public function get(): array
    {
        return $this->messages;
    }

    public function put(array $messages): void
    {
        $this->messages = $messages;
    }
}
