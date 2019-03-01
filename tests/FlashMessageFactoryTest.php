<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\FlashMessage\FlashMessageFactory;

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
        $message = (new FlashMessage)->info();

        $this->app->instance(FlashMessage::class, $message);

        $this->assertSame($message, $this->flashMessageFactory->make());
        $this->assertSame($message, $this->flashMessageFactory->make());
    }
}
