<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessagesBag;
use Coderello\Laraflash\FlashMessagesBagPreparer;

class FlashMessageBagPreparerTest extends AbstractTestCase
{
    public function test_hops_amount_will_not_be_decremented_if_delay_is_greater_than_zero()
    {
        $bag = new FlashMessagesBag();

        $preparer = (new FlashMessagesBagPreparer($bag));

        $bag->add()->hops(2)->delay(2);

        $preparer->prepare();

        $this->assertSame(2, $bag[0]->toArray()['hops']);

        $preparer->prepare();

        $this->assertSame(2, $bag[0]->toArray()['hops']);
    }

    public function test_hops_amount_will_be_decremented_if_delay_is_zero()
    {
        $bag = new FlashMessagesBag();

        $preparer = (new FlashMessagesBagPreparer($bag));

        $bag->add()->hops(5)->delay(0);

        $preparer->prepare();

        $this->assertSame(4, $bag[0]->toArray()['hops']);

        $preparer->prepare();

        $this->assertSame(3, $bag[0]->toArray()['hops']);
    }

    public function test_delay_will_be_decremented_if_it_is_greater_than_zero()
    {
        $bag = new FlashMessagesBag();

        $preparer = (new FlashMessagesBagPreparer($bag));

        $bag->add()->hops(4)->delay(2);

        $preparer->prepare();

        $this->assertSame(1, $bag[0]->toArray()['delay']);

        $preparer->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);
    }

    public function test_delay_will_not_be_decremented_if_it_is_zero()
    {
        $bag = new FlashMessagesBag();

        $preparer = (new FlashMessagesBagPreparer($bag));

        $bag->add()->hops(6)->delay(0);

        $preparer->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);

        $preparer->prepare();

        $this->assertSame(0, $bag[0]->toArray()['delay']);
    }

    public function test_message_will_be_deleted_if_hops_amount_is_less_or_equal_to_one_and_delay_is_zero()
    {
        $bag = new FlashMessagesBag();

        $preparer = (new FlashMessagesBagPreparer($bag));

        $bag->add()->hops(1)->delay(0);

        $preparer->prepare();

        $this->assertFalse(isset($bag[0]));
    }
}
