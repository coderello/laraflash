<?php

namespace Coderello\Laraflash\Contracts;

use ArrayAccess;

interface FlashMessagesBag extends ArrayAccess
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
