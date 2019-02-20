<?php

namespace Coderello\Laraflash\Tests\Support;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\FlashMessage\FlashMessageFactoryContract;

class FlashMessageFactory implements FlashMessageFactoryContract
{
    public function make(): FlashMessage
    {
        return new FlashMessage(new FlashMessageRenderer);
    }
}
