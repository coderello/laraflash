<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Laraflash\Laraflash;
use Coderello\Laraflash\Tests\Support\FlashMessageFactory;
use Coderello\Laraflash\Tests\Support\LaraflashRenderer;
use Coderello\Laraflash\Tests\Support\MessagesStorage;

class LaraflashTest extends TestCase
{
    /** @var FlashMessageFactory */
    protected $flashMessageFactory;

    /** @var MessagesStorage */
    protected $messagesStorage;

    /** @var LaraflashRenderer */
    protected $laraflashRenderer;

    /** @var Laraflash */
    protected $laraflash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->flashMessageFactory = new FlashMessageFactory;

        $this->messagesStorage = new MessagesStorage;

        $this->laraflashRenderer = new LaraflashRenderer;

        $this->laraflash = new Laraflash(
            $this->flashMessageFactory,
            $this->messagesStorage,
            $this->laraflashRenderer
        );
    }

    public function testLoadMethod()
    {
        $firstMessage = $this->flashMessageFactory->make();
        $secondMessage = $this->flashMessageFactory->make();

        $this->messagesStorage->messages = [
            $firstMessage,
            $secondMessage,
            'invalid value',
        ];

        $this->assertCount(0, $this->laraflash->all());

        $this->laraflash->load();

        $this->assertCount(2, $this->laraflash->all());

        $this->assertSame($firstMessage, $this->laraflash->all()->first());
        $this->assertSame($secondMessage, $this->laraflash->all()->last());
    }

    public function testSaveMethod()
    {
        $message = $this->laraflash->message();

        $this->assertCount(0, $this->messagesStorage->messages);

        $this->laraflash->save();

        $this->assertCount(1, $this->messagesStorage->messages);

        $this->assertSame($message, $this->messagesStorage->messages[0]);
    }

    public function testMessageMethod()
    {
        $this->assertCount(0, $this->laraflash->all());

        $message = $this->laraflash->message();

        $this->assertCount(1, $this->laraflash->all());

        $this->assertSame($message, $this->laraflash->all()->first());
    }

    public function testKeepMethod()
    {
        $firstMessage = $this->laraflash->message()->hops(5);
        $secondMessage = $this->laraflash->message()->hops(3);

        $this->assertSame(5, $firstMessage->get('hops'));
        $this->assertSame(3, $secondMessage->get('hops'));

        $this->laraflash->keep();

        $this->assertSame(6, $firstMessage->get('hops'));
        $this->assertSame(4, $secondMessage->get('hops'));
    }

    public function testClearMethod()
    {
        $this->laraflash->message();

        $this->assertCount(1, $this->laraflash->all());

        $this->laraflash->clear();

        $this->assertCount(0, $this->laraflash->all());
    }

    public function testAllMethod()
    {
        $message = $this->laraflash->message();

        $this->assertCount(1, $this->laraflash->all());

        $this->assertSame($message, $this->laraflash->all()->first());
    }

    public function testReadyMethod()
    {
        $this->laraflash->message();

        $readyMessage = $this->laraflash->message()->now();

        $this->assertCount(1, $this->laraflash->ready());

        $this->assertSame($readyMessage, $this->laraflash->ready()->first());
    }

    public function testTouchMethod()
    {
        $this->laraflash->message()->delay(2)->hops(2);

        foreach ([[2, 2], [1, 2], [0, 2], [0, 1]] as $values) {
            $this->assertSame($values[0], $this->laraflash->all()->first()->get('delay'));
            $this->assertSame($values[1], $this->laraflash->all()->first()->get('hops'));

            $this->laraflash->touch();
        }

        $this->assertSame(0, $this->laraflash->all()->count());
    }

    public function testToArrayMethod()
    {
        $firstMessage = $this->laraflash->message()->now();

        $secondMessage = $this->laraflash->message()->now();

        $this->laraflash->message();

        $this->assertSame(
            [$firstMessage->toArray(), $secondMessage->toArray()],
            $this->laraflash->toArray()
        );
    }

    public function testJsonSerializeMethod()
    {
        $this->laraflash->message()->now();

        $this->laraflash->message()->now();

        $this->laraflash->message();

        $this->assertSame(
            $this->laraflash->toArray(),
            $this->laraflash->jsonSerialize()
        );
    }

    public function testToJsonMethod()
    {
        $this->laraflash->message()->now();

        $this->laraflash->message()->now();

        $this->laraflash->message();

        $this->assertSame(
            $this->laraflash->jsonSerialize(),
            json_decode($this->laraflash->toJson(), true)
        );
    }

    public function testOffsetExistsMethod()
    {
        $this->assertFalse($this->laraflash->offsetExists(0));

        $this->laraflash->message();

        $this->assertTrue($this->laraflash->offsetExists(0));
    }

    public function testOffsetGetMethod()
    {
        $this->assertNull($this->laraflash->offsetGet(0));

        $message = $this->laraflash->message();

        $this->assertSame($message, $this->laraflash->offsetGet(0));
    }

    public function testOffsetSetMethod()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->laraflash->offsetSet(0, $this->flashMessageFactory->make());
    }

    public function testOffsetUnsetMethod()
    {
        $this->laraflash->message();

        $message = $this->laraflash->message();

        $this->laraflash->offsetUnset(0);

        $this->assertFalse($this->laraflash->offsetExists(0));

        $this->assertTrue($this->laraflash->offsetExists(1));

        $this->assertSame($message, $this->laraflash->offsetGet(1));
    }

    public function testToHtmlMethod()
    {
        $this->assertSame(
            $this->laraflash->render(),
            $this->laraflash->toHtml()
        );
    }

    public function testRenderMethod()
    {
        $this->assertSame(
            LaraflashRenderer::RESULT,
            $this->laraflash->render()
        );
    }
}
