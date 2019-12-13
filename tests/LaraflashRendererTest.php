<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Laraflash\Laraflash;
use Coderello\Laraflash\Laraflash\LaraflashRenderer;
use Coderello\Laraflash\Tests\Support\FlashMessageFactory;
use Coderello\Laraflash\Tests\Support\FlashMessageRenderer;
use Coderello\Laraflash\Tests\Support\MessagesStorage;
use Illuminate\Config\Repository as ConfigRepository;

class LaraflashRendererTest extends AbstractTestCase
{
    /** @var ConfigRepository */
    protected $configRepository;

    /** @var FlashMessageRenderer */
    protected $flashMessageRenderer;

    /** @var LaraflashRenderer */
    protected $laraflashRenderer;

    /** @var Laraflash */
    protected $laraflash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configRepository = new ConfigRepository;

        $this->flashMessageRenderer = new FlashMessageRenderer;

        $this->laraflashRenderer = new LaraflashRenderer(
            $this->flashMessageRenderer,
            $this->configRepository
        );

        $this->laraflash = new Laraflash(
            new FlashMessageFactory,
            new MessagesStorage,
            $this->laraflashRenderer
        );
    }

    public function testGetSeparatorMethod()
    {
        $this->assertNull($this->laraflashRenderer->getSeparator());

        $this->configRepository->set('laraflash.separator', 'foo');

        $this->assertSame('foo', $this->laraflashRenderer->getSeparator());

        $this->laraflashRenderer->setSeparator('bar');

        $this->assertSame('bar', $this->laraflashRenderer->getSeparator());
    }

    public function testSetSeparatorMethod()
    {
        $this->laraflashRenderer->setSeparator('foo');

        $this->assertSame('foo', $this->laraflashRenderer->getSeparator());
    }

    public function testRenderMethod()
    {
        $this->laraflash->message()->now();
        $this->laraflash->message()->now();

        $this->laraflashRenderer->setSeparator('SEPARATOR');

        $this->assertSame(
            FlashMessageRenderer::RESULT.'SEPARATOR'.FlashMessageRenderer::RESULT,
            $this->laraflashRenderer->render($this->laraflash)
        );
    }
}
