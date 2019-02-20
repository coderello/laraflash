<?php

namespace Coderello\Laraflash\Tests\Support;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\FlashMessage\FlashMessageRendererContract;

class FlashMessageRenderer implements FlashMessageRendererContract
{
    const RESULT = 'RENDERED MESSAGE';

    public function render(FlashMessage $flashMessage): string
    {
        return self::RESULT;
    }
}
