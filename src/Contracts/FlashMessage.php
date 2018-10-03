<?php

namespace Coderello\Laraflash\Contracts;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;

interface FlashMessage extends Arrayable, ArrayAccess, Renderable, Jsonable, JsonSerializable
{
    public function title(string $title): self;

    public function content(string $content): self;

    public function type(string $type): self;

    public function hops(int $hops): self;

    public function delay(int $delay): self;

    public function important(bool $important): self;

    public function now(): self;

    public function keep(): self;
}
