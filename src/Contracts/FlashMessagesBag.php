<?php

namespace Coderello\Laraflash\Contracts;

use ArrayAccess;
use Illuminate\Contracts\Support\Renderable;

interface FlashMessagesBag extends ArrayAccess, Renderable
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
