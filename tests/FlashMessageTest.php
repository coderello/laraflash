<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Coderello\Laraflash\FlashMessage;

class FlashMessageTest extends AbstractTestCase
{
    public function test_initial_state()
    {
        $message = new FlashMessage();
        $messageValues = $message->toArray();

        $this->assertEquals(null, $messageValues['title']);
        $this->assertEquals(null, $messageValues['content']);
        $this->assertEquals(null, $messageValues['type']);
        $this->assertEquals(1, $messageValues['hops']);
        $this->assertEquals(1, $messageValues['delay']);
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
}
