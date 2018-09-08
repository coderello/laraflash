<?php

namespace Coderello\Laraflash\Tests;

class HelpersTest extends AbstractTestCase
{
    public function test_laraflash_helper_returns_appropriate_object()
    {
        $this->assertSame(app('laraflash.bag'), laraflash());
    }
}
