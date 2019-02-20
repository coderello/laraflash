<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\FlashMessage\FlashMessageFactory;
use Coderello\Laraflash\Tests\Support\FlashMessageRenderer;

class FlashMessageFactoryTest extends AbstractTestCase
{
    /** @var FlashMessageFactory */
    protected $flashMessageFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->flashMessageFactory = new FlashMessageFactory;
    }

    public function testMakeMethod()
    {
        $message = (new FlashMessage(new FlashMessageRenderer))->info();

        $this->app->instance(FlashMessage::class, $message);

        $this->assertSame($message, $this->flashMessageFactory->make());
        $this->assertSame($message, $this->flashMessageFactory->make());
    }
}
