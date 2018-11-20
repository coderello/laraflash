<?php

namespace Coderello\Laraflash\Events;

use Coderello\Laraflash\FlashMessage;

class FlashMessageCreated
{
    public $message;

    public function __construct(FlashMessage $message)
    {
        $this->message = $message;
    }
}
