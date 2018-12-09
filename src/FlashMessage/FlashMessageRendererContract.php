<?php

namespace Coderello\Laraflash\FlashMessage;

interface FlashMessageRendererContract
{
    public function render(FlashMessage $flashMessage): string;
}
