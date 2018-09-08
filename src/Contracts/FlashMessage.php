<?php

namespace Coderello\Laraflash\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use ArrayAccess;
use Illuminate\Contracts\Support\Renderable;

interface FlashMessage extends Arrayable, ArrayAccess, Renderable
{
    public function title(string $title): FlashMessage;

    public function content(string $content): FlashMessage;

    public function type(string $type): FlashMessage;

    public function hops(int $hops): FlashMessage;

    public function delay(int $delay): FlashMessage;

    public function now(): FlashMessage;

    public function keep(): FlashMessage;
}
