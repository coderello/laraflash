<?php

namespace Coderello\Laraflash\MessagesStorage;

class ArrayMessagesStorage implements MessagesStorage
{
    protected $messages = [];

    public function get(): array
    {
        return $this->messages;
    }

    public function put(array $messages): void
    {
        $this->messages = $messages;
    }
}
