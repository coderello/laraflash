<?php

namespace Coderello\Laraflash\Laraflash;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class LaraflashRenderer implements LaraflashRendererContract
{
    protected $configRepository;

    protected $separator;

    public function __construct(ConfigRepository $configRepository)
    {
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
                return $message->render();
            })
            ->implode($this->getSeparator());
    }
}
