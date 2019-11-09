<?php

namespace Coderello\Laraflash\FlashMessage;

use Coderello\Laraflash\Exceptions\SkinNotFoundException;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ViewFlashMessageRenderer implements FlashMessageRendererContract
{
    protected $viewFactory;

    protected $configRepository;

    protected $skin;

    public function __construct(ViewFactory $viewFactory, ConfigRepository $configRepository)
    {
        $this->viewFactory = $viewFactory;

        $this->configRepository = $configRepository;
    }

    public function setSkin(string $skin)
    {
        $this->skin = $skin;
    }

    public function getSkin()
    {
        return $this->skin ?? $this->configRepository->get('laraflash.skin');
    }

    public function render(FlashMessage $flashMessage): string
    {
        $skin = $this->getSkin();

        if (! $this->viewFactory->exists($skin)) {
            throw new SkinNotFoundException($skin);
        }

        return $this->viewFactory->make($skin, $flashMessage->toArray());
    }
}
