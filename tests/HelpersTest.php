<?php

namespace Coderello\Laraflash\Tests;

use Coderello\Laraflash\Laraflash;

class HelpersTest extends AbstractTestCase
{
    public function test_laraflash_helper_returns_laraflash_object()
    {
        $this->assertTrue(laraflash() instanceof Laraflash);
    }
}
