<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\FlashMessagesBag;

class LaraflashServiceProviderTest extends AbstractTestCase
{
    public function test_receiving_flash_messages_bag_instance_from_container()
    {
        $bag = app()->make(FlashMessagesBag::class);

        $this->assertTrue($bag instanceof FlashMessagesBag);
    }

    public function test_bags_both_from_session_and_container_are_same()
    {
        $bagFromContainer = app()->make(FlashMessagesBag::class);

        $bagFromSession = session('flash_messages_bag');

        $this->assertSame($bagFromContainer, $bagFromSession);
    }
}
