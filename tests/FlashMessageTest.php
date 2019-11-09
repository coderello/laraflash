<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Coderello\Laraflash\FlashMessage\FlashMessage;
use Illuminate\Support\Arr;

class FlashMessageTest extends AbstractTestCase
{
    /** @var FlashMessage */
    protected $flashMessage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->flashMessage = new FlashMessage;
    }

    protected function getMessageState(array $override = [])
    {
        $initialState = [
            'content' => null,
            'title' => null,
            'type' => null,
            'hops' => 1,
            'delay' => 1,
        ];

        return array_merge($initialState, $override);
    }

    public function testInitialState()
    {
        $expected = $this->getMessageState();

        $actual = $this->flashMessage->toArray();

        $this->assertSame(
            Arr::sortRecursive($expected),
            Arr::sortRecursive($actual)
        );
    }

    public function testContentMethod()
    {
        $message = $this->flashMessage
            ->content('foo');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['content' => 'foo'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testTitleMethod()
    {
        $message = $this->flashMessage
            ->title('foo');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['title' => 'foo'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testTypeMethod()
    {
        $message = $this->flashMessage
            ->type('foo');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['type' => 'foo'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testDangerMethod()
    {
        $message = $this->flashMessage
            ->danger();

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['type' => 'danger'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testWarningMethod()
    {
        $message = $this->flashMessage
            ->warning();

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['type' => 'warning'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testInfoMethod()
    {
        $message = $this->flashMessage
            ->info();

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['type' => 'info'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testSuccessMethod()
    {
        $message = $this->flashMessage
            ->success();

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['type' => 'success'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testHopsMethod()
    {
        $message = $this->flashMessage
            ->hops(5);

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['hops' => 5])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testHopsMethodWithInvalidHopsAmount()
    {
        $this->expectException(InvalidHopsAmountException::class);

        $this->flashMessage
            ->hops(0);
    }

    public function testDelayMethod()
    {
        $message = $this->flashMessage
            ->delay(5);

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['delay' => 5])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testDelayMethodWithInvalidDelay()
    {
        $this->expectException(InvalidDelayException::class);

        $this->flashMessage
            ->delay(-1);
    }

    public function testNowMethod()
    {
        $message = $this->flashMessage
            ->delay(5);

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['delay' => 5])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testKeepMethod()
    {
        $message = $this->flashMessage
            ->hops(5)
            ->keep();

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['hops' => 6])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testAttributeMethodWithNonNullValue()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState(['foo' => 'bar'])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testAttributeMethodWithNullValue()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar')
            ->attribute('foo', null);

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState()),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testGetMethod()
    {
        $message = $this->flashMessage
            ->hops(5)
            ->attribute('foo', 'bar');

        $this->assertSame(5, $message->get('hops'));
        $this->assertSame('bar', $message->get('foo'));
        $this->assertSame(null, $message->get('baz'));
    }

    public function testToArrayMethod()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar')
            ->delay(4);

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState([
                'foo' => 'bar',
                'delay' => 4,
            ])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testToJsonMethod()
    {
        $message = $this->flashMessage;

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState()),
            Arr::sortRecursive(json_decode($message->toJson(), true))
        );
    }

    public function testJsonSerialize()
    {
        $message = $this->flashMessage;

        $this->assertSame(
            Arr::sortRecursive($message->toArray()),
            Arr::sortRecursive($message->jsonSerialize())
        );
    }

    public function testOffsetExistsMethod()
    {
        $message = $this->flashMessage;

        $this->assertFalse($message->offsetExists('foo'));

        $message->attribute('foo', 'bar');

        $this->assertTrue($message->offsetExists('foo'));
    }

    public function testOffsetGetMethod()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar');

        $this->assertSame($message->offsetGet('foo'), 'bar');
    }

    public function testOffsetGetMethodWithNonexistentAttribute()
    {
        $message = $this->flashMessage;

        $this->expectException(\ErrorException::class);

        $message->offsetGet('foo');
    }

    public function testOffsetSetMethod()
    {
        $message = $this->flashMessage;

        $message['foo'] = 'bar';

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState([
                'foo' => 'bar',
            ])),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testOffsetUnsetMethod()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar');

        $message->offsetUnset('foo');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState()),
            Arr::sortRecursive($message->toArray())
        );
    }

    public function testMagicGetMethod()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar');

        $this->assertSame('bar', $message->__get('foo'));
        $this->assertSame(null, $message->__get('baz'));
    }

    public function testMagicSetMethod()
    {
        $message = $this->flashMessage;

        $message->__set('foo', 'bar');

        $this->assertSame('bar', $message->__get('foo'));
    }

    public function testMagicIssetMethod()
    {
        $message = $this->flashMessage;

        $this->assertFalse($message->__isset('foo'));

        $message->attribute('foo', 'bar');

        $this->assertTrue($message->__isset('foo'));
    }

    public function testMagicUnsetMethod()
    {
        $message = $this->flashMessage
            ->attribute('foo', 'bar');

        $message->__unset('foo');

        $this->assertSame(
            Arr::sortRecursive($this->getMessageState()),
            Arr::sortRecursive($message->toArray())
        );
    }
}
