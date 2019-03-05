<?php

namespace Coderello\Laraflash\Laraflash;

interface LaraflashRendererContract
{
    public function render(Laraflash $laraflash): string;
}
