<?php

namespace Coderello\Laraflash\Tests;

use ArrayAccess;
use ErrorException;
use Coderello\Laraflash\FlashMessage;
use Coderello\Laraflash\FlashMessagesBag;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;
use Coderello\Laraflash\Contracts\FlashMessagesBag as FlashMessagesBagContract;

class FlashMessageBagTest extends AbstractTestCase
{
    public function test_implements_contract()
    {
        $this->assertTrue(new FlashMessagesBag instanceof FlashMessagesBagContract);
    }

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

    public function test_keep_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2);

        $bag->add()->hops(6);

        $bag->keep();

        $this->assertEquals(3, $bag[0]['hops']);

        $this->assertEquals(7, $bag[1]['hops']);
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

    public function test_prepare_method_hops_amount_will_not_be_decremented_if_delay_is_greater_than_zero()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2)->delay(2);

        $bag->prepare();

        $this->assertSame(2, $bag[0]->toArray()['hops']);

        $bag->prepare();

        $this->assertSame(2, $bag[0]->toArray()['hops']);
    }

    public function test_prepare_method_hops_amount_will_be_decremented_if_delay_is_zero()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(5)->delay(0);

        $bag->prepare();

        $this->assertSame(4, $bag[0]->toArray()['hops']);

        $bag->prepare();

        $this->assertSame(3, $bag[0]->toArray()['hops']);
    }

    public function test_prepare_method_delay_will_be_decremented_if_it_is_greater_than_zero()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(4)->delay(2);

        $bag->prepare();

        $this->assertSame(1, $bag[0]->toArray()['delay']);

        $bag->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);
    }

    public function test_prepare_method_delay_will_not_be_decremented_if_it_is_zero()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(6)->delay(0);

        $bag->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);

        $bag->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);
    }

    public function test_prepare_method_message_will_be_deleted_if_hops_amount_is_less_or_equal_to_one_and_delay_is_zero()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(1)->delay(0);

        $bag->prepare();

        $this->assertFalse(isset($bag[0]));
    }

    public function test_json_serialize_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2);

        $bag->prepare();

        $response = $bag->jsonSerialize();

        $this->assertEquals(2, $response[0]['hops']);
    }

    public function test_to_json_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2);

        $bag->prepare();

        $response = $bag->toJson();

        $this->assertEquals(2, json_decode($response)[0]->hops);
    }

    public function test_to_array_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2);

        $bag->prepare();

        $this->assertEquals([
            'title' => null,
            'content' => null,
            'type' => 'info',
            'hops' => 2,
            'delay' => 0,
            'important' => false,
        ], $bag->toArray()[0]);
    }

    public function test_render_method()
    {
        $bag = new FlashMessagesBag();

        $bag->add()->hops(2);

        $bag->prepare();

        try {
            $this->assertEquals(
                view(config('laraflash.skin'), [
                    'title' => null,
                    'content' => null,
                    'type' => 'info',
                ])->render(),
                $bag->render()
            );
        } catch (\Throwable $e) {
        }
    }
}
