<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Tests\Support\FlashMessageFactory;
use Coderello\Laraflash\MessagesStorage\ArrayMessagesStorage;

class ArrayMessagesStorageTest extends AbstractTestCase
{
    /** @var ArrayMessagesStorage */
    protected $arrayMessagesStorage;

    /** @var FlashMessageFactory */
    protected $flashMessageFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->arrayMessagesStorage = new ArrayMessagesStorage;

        $this->flashMessageFactory = new FlashMessageFactory;
    }

    public function test()
    {
        $messages = [
            $this->flashMessageFactory->make(),
            $this->flashMessageFactory->make(),
        ];

        $this->assertSame([], $this->arrayMessagesStorage->get());

        $this->arrayMessagesStorage->put($messages);

        $this->assertSame($messages, $this->arrayMessagesStorage->get());
    }
}
