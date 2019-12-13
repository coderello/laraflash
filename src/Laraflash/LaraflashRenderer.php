<?php

namespace Coderello\Laraflash\Laraflash;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\FlashMessage\FlashMessageRendererContract as FlashMessageRenderer;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class LaraflashRenderer implements LaraflashRendererContract
{
    protected $flashMessageRenderer;

    protected $configRepository;

    protected $separator;

    public function __construct(FlashMessageRenderer $flashMessageRenderer, ConfigRepository $configRepository)
    {
        $this->flashMessageRenderer = $flashMessageRenderer;

        $this->configRepository = $configRepository;
    }

    public function setSeparator(string $separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator ?? $this->configRepository->get('laraflash.separator');
    }

    public function render(Laraflash $laraflash): string
    {
        return $laraflash->ready()
            ->map(function (FlashMessage $message) {
                return $this->flashMessageRenderer->render($message);
            })
            ->implode($this->getSeparator());
    }
}
