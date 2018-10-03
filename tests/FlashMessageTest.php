<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessage;
use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Coderello\Laraflash\Contracts\FlashMessage as FlashMessageContract;

class FlashMessageTest extends AbstractTestCase
{
    public function test_implements_contract()
    {
        $this->assertTrue(new FlashMessage instanceof FlashMessageContract);
    }

    public function test_initial_state()
    {
        $message = new FlashMessage();
        $messageValues = $message->toArray();

        $this->assertEquals(null, $messageValues['title']);
        $this->assertEquals(null, $messageValues['content']);
        $this->assertEquals(null, $messageValues['type']);
        $this->assertEquals(1, $messageValues['hops']);
        $this->assertEquals(1, $messageValues['delay']);
        $this->assertEquals(false, $messageValues['important']);
    }

    public function test_title_method()
    {
        $message = new FlashMessage();
        $message->title('hello');
        $messageValues = $message->toArray();

        $this->assertEquals('hello', $messageValues['title']);
    }

    public function test_content_method()
    {
        $message = new FlashMessage();
        $message->content('hello');
        $messageValues = $message->toArray();

        $this->assertEquals('hello', $messageValues['content']);
    }

    public function test_type_method()
    {
        $message = new FlashMessage();
        $message->type('hello');
        $messageValues = $message->toArray();

        $this->assertEquals('hello', $messageValues['type']);
    }

    public function test_hops_method()
    {
        $message = new FlashMessage();
        $message->hops(2);
        $messageValues = $message->toArray();

        $this->assertEquals(2, $messageValues['hops']);
    }

    public function test_hops_method_with_invalid_argument()
    {
        $this->expectException(InvalidHopsAmountException::class);

        $message = new FlashMessage();
        $message->hops(-1);
    }

    public function test_delay_method()
    {
        $message = new FlashMessage();
        $message->delay(4);
        $messageValues = $message->toArray();

        $this->assertEquals(4, $messageValues['delay']);
    }

    public function test_delay_method_with_invalid_argument()
    {
        $this->expectException(InvalidDelayException::class);

        $message = new FlashMessage();
        $message->delay(-1);
    }

    public function test_important_method()
    {
        $message = new FlashMessage();

        $message->important();

        $this->assertEquals(true, $message['important']);

        $message->important(false);

        $this->assertEquals(false, $message['important']);

        $message->important(true);

        $this->assertEquals(true, $message['important']);
    }

    public function test_now_method()
    {
        $message = new FlashMessage();
        $message->delay(5)->now();
        $messageValues = $message->toArray();

        $this->assertEquals(0, $messageValues['delay']);
    }

    public function test_keep_method()
    {
        $message = new FlashMessage();
        $message->hops(3)->keep();
        $messageValues = $message->toArray();

        $this->assertEquals(4, $messageValues['hops']);
    }

    public function test_to_array_method()
    {
        $message = new FlashMessage();
        $message->title('hello')
            ->content('world')
            ->type('info')
            ->hops(5)
            ->delay(3)
            ->important();

        $this->assertEquals([
            'title' => 'hello',
            'content' => 'world',
            'type' => 'info',
            'hops' => 5,
            'delay' => 3,
            'important' => true,
        ], $message->toArray());
    }

    public function test_offset_exists_method()
    {
        $message = new FlashMessage();

        $this->assertTrue($message->offsetExists('title'));
        $this->assertTrue($message->offsetExists('content'));
        $this->assertTrue($message->offsetExists('type'));
        $this->assertTrue($message->offsetExists('hops'));
        $this->assertTrue($message->offsetExists('delay'));
        $this->assertFalse($message->offsetExists('fail'));
    }

    public function test_offset_get_method()
    {
        $message = new FlashMessage();

        $message->title('hello');

        $this->assertEquals('hello', $message['title']);
    }

    public function test_offset_get_method_with_invalid_argument()
    {
        $message = new FlashMessage();

        $this->expectException(InvalidArgumentException::class);

        $message->offsetGet('whoops');
    }

    public function test_offset_set_method()
    {
        $message = new FlashMessage();

        $message->offsetSet('title', 'it works');

        $this->assertEquals('it works', $message['title']);
    }

    public function test_offset_set_method_with_invalid_argument()
    {
        $message = new FlashMessage();

        $this->expectException(InvalidArgumentException::class);

        $message->offsetSet('whoops', 'some value');
    }

    public function test_offset_unset_method_does_not_affect_message()
    {
        $message = new FlashMessage();

        $message->title('hello');

        $messageValues = $message->toArray();

        unset($message['title']);

        $this->assertSame($messageValues, $message->toArray());
    }

    public function test_json_serialize_method()
    {
        $message = new FlashMessage();

        $message->title('hello');

        $response = $message->jsonSerialize();

        $this->assertEquals('hello', $response['title']);
    }

    public function test_to_json_method()
    {
        $message = new FlashMessage();

        $message->title('hello');

        $response = $message->toJson();

        $this->assertEquals('hello', json_decode($response)->title);
    }

    public function test_render_method()
    {
        $message = new FlashMessage();

        $message->title('hello');

        $message->type('hello');

        $message->content('hello');

        try {
            $this->assertEquals(
                view(config('laraflash.skin'), [
                    'title' => 'hello',
                    'type' => 'hello',
                    'content' => 'hello',
                ])->render(),
                $message->render()
            );
        } catch (\Throwable $e) {
        }
    }
}
