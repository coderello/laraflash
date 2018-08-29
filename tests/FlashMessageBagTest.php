<?php

namespace Coderello\Laraflash\Tests;

use ArrayAccess;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;
use Coderello\Laraflash\FlashMessage;
use Coderello\Laraflash\FlashMessagesBag;
use ErrorException;

class FlashMessageBagTest extends AbstractTestCase
{
    public function test_initial_state()
    {
        $bag = new FlashMessagesBag();

        $this->assertEquals([], $bag->all());
        $this->assertEquals([], $bag->ready());
    }

    public function test_add_method_without_arguments()
    {
        $bag = new FlashMessagesBag();

        $this->assertEquals(0, count($bag->all()));

        $bag->add();

        $this->assertEquals(1, count($bag->all()));

        $message = $bag->all()[0];

        $this->assertTrue($message instanceof FlashMessage);
    }

    public function test_add_method_with_message_argument()
    {
        $bag = new FlashMessagesBag();

        $this->assertEquals(0, count($bag->all()));

        $message = new FlashMessage();

        $bag->add($message);

        $this->assertEquals(1, count($bag->all()));

        $this->assertSame($message, $bag->all()[0]);
    }

    public function test_clear_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add();

        $this->assertEquals(1, count($bag->all()));

        $bag->clear();

        $this->assertEquals(0, count($bag->all()));
    }

    public function test_all_method()
    {
        $bag = new FlashMessagesBag();

        $firstMessage = $bag->add();
        $secondMessage = $bag->add();

        $this->assertSame([
            0 => $firstMessage,
            1 => $secondMessage,
        ], $bag->all());
    }

    public function test_ready_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add();
        $secondMessage = $bag->add()->now();
        $thirdMessage = $bag->add()->delay(0);

        $this->assertSame([
            1 => $secondMessage,
            2 => $thirdMessage,
        ], $bag->ready());
    }

    public function test_bag_implements_array_access()
    {
        $this->assertTrue(new FlashMessagesBag() instanceof ArrayAccess);
    }

    public function test_offset_exists_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add();

        $this->assertTrue($bag->offsetExists(0));
        $this->assertFalse($bag->offsetExists(1));
    }

    public function test_offset_get_method()
    {
        $bag = new FlashMessagesBag();

        $message = $bag->add();

        $this->assertSame($message, $bag[0]);

        $this->expectException(ErrorException::class);

        $bag[1];
    }

    public function test_offset_set_method()
    {
        $bag = new FlashMessagesBag();

        $message = new FlashMessage();

        $bag[2] = $message;

        $this->assertEquals(1, count($bag->all()));

        $this->assertSame($message, $bag[2]);

        $this->expectException(InvalidArgumentException::class);

        $bag[3] = 'Hello, I\'m string.';
    }

    public function test_offset_unset_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add();

        $secondMessage = $bag->add();

        unset($bag[0]);

        $this->assertSame([
            1 => $secondMessage,
        ], $bag->all());
    }
}
