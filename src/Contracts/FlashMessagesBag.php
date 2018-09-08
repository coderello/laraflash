<?php

namespace Coderello\Laraflash\Contracts;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use JsonSerializable;

interface FlashMessagesBag extends Arrayable, ArrayAccess, Renderable, Jsonable, JsonSerializable
{
    public function add(?FlashMessage $message = null): FlashMessage;

    public function clear(): self;

    public function keep(): self;

    /**
     * @return FlashMessage[]
     */
    public function all(): array;

    /**
     * @return FlashMessage[]
     */
    public function ready(): array;

    public function prepare(): self;
}
