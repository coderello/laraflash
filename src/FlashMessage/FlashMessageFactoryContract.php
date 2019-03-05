<?php

namespace Coderello\Laraflash\FlashMessage;

interface FlashMessageFactoryContract
{
    public function make(): FlashMessage;
}
