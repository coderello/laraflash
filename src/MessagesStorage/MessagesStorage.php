<?php

namespace Coderello\Laraflash\MessagesStorage;

interface MessagesStorage
{
    public function get(): array;

    public function put(array $messages): void;
}
