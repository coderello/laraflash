<?php

namespace Coderello\Laraflash\MessagesStorage;

interface MessagesStorageContract
{
    public function get(): array;

    public function put(array $messages): void;
}
