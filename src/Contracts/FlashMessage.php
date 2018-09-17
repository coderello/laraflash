<?php

namespace Coderello\Laraflash\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use ArrayAccess;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use JsonSerializable;

interface FlashMessage extends Arrayable, ArrayAccess, Renderable, Jsonable, JsonSerializable
{
    public function title(string $title): FlashMessage;

    public function content(string $content): FlashMessage;

    public function type(string $type): FlashMessage;

    public function hops(int $hops): FlashMessage;

    public function delay(int $delay): FlashMessage;

    public function important(bool $important): FlashMessage;

    public function now(): FlashMessage;

    public function keep(): FlashMessage;
}
