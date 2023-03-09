<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\MessagesStorage\SessionMessagesStorage;
use Coderello\Laraflash\Tests\Support\FlashMessageFactory;
use Illuminate\Contracts\Session\Session;

class SessionMessagesStorageTest extends TestCase
{
    /** @var Session */
    protected $session;

    /** @var SessionMessagesStorage */
    protected $sessionMessagesStorage;

    /** @var FlashMessageFactory */
    protected $flashMessageFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = $this->app->make(Session::class);

        $this->session->flush();

        $this->sessionMessagesStorage = new SessionMessagesStorage($this->session);

        $this->flashMessageFactory = new FlashMessageFactory;
    }

    public function testGetKeyMethod()
    {
        $this->assertSame('flash_messages', $this->sessionMessagesStorage->getKey());

        $this->sessionMessagesStorage->setKey('foo');

        $this->assertSame('foo', $this->sessionMessagesStorage->getKey());
    }

    public function testSetKeyMethod()
    {
        $this->sessionMessagesStorage->setKey('foo');

        $this->assertSame('foo', $this->sessionMessagesStorage->getKey());
    }

    public function testPutMethod()
    {
        $this->assertEmpty($this->session->get('flash_messages'));

        $messages = [
            $this->flashMessageFactory->make(),
            $this->flashMessageFactory->make(),
        ];

        $this->sessionMessagesStorage->put($messages);

        $this->assertSame($messages, $this->session->get('flash_messages'));
    }
}
