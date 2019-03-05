<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\Tests\Support\ViewFactory;
use Illuminate\Config\Repository as ConfigRepository;
use Coderello\Laraflash\Exceptions\SkinNotFoundException;
use Coderello\Laraflash\FlashMessage\ViewFlashMessageRenderer;

class ViewFlashMessageRendererTest extends AbstractTestCase
{
    /** @var ConfigRepository */
    protected $configRepository;

    /** @var ViewFactory */
    protected $viewFactory;

    /** @var ViewFlashMessageRenderer */
    protected $viewFlashMessageRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configRepository = new ConfigRepository;

        $this->viewFactory = new ViewFactory;

        $this->viewFlashMessageRenderer = new ViewFlashMessageRenderer(
            $this->viewFactory,
            $this->configRepository
        );
    }

    public function testGetSkinMethod()
    {
        $this->assertNull($this->viewFlashMessageRenderer->getSkin());

        $this->configRepository->set('laraflash.skin', 'foo');

        $this->assertSame('foo', $this->viewFlashMessageRenderer->getSkin());

        $this->viewFlashMessageRenderer->setSkin('bar');

        $this->assertSame('bar', $this->viewFlashMessageRenderer->getSkin());
    }

    public function testSetSkinMethod()
    {
        $this->viewFlashMessageRenderer->setSkin('foo');

        $this->assertSame('foo', $this->viewFlashMessageRenderer->getSkin());
    }

    public function testRenderMethodWithNonexistentSkin()
    {
        $this->viewFactory->exists = false;

        $this->expectException(SkinNotFoundException::class);

        $this->viewFlashMessageRenderer->render(
            new FlashMessage
        );
    }

    public function testRenderMethodWithExistentSkin()
    {
        $this->viewFactory->exists = true;

        $content = $this->viewFlashMessageRenderer->render(
            new FlashMessage
        );

        $this->assertSame(ViewFactory::MADE_CONTENT, $content);
    }
}
