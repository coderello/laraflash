<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Contracts\FlashMessagesBag;

class LaraflashServiceProviderTest extends AbstractTestCase
{
    public function test_receiving_flash_messages_bag_instance_from_container()
    {
        $bag = app('laraflash.bag');

        $this->assertTrue($bag instanceof FlashMessagesBag);
    }

    public function test_bags_both_from_session_and_container_are_same()
    {
        $bagFromContainer = app('laraflash.bag');

        $bagFromSession = session('flash_messages_bag');

        $this->assertSame($bagFromContainer, $bagFromSession);
    }
}
