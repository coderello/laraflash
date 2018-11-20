<?php

namespace Coderello\Laraflash\Tests;

use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Coderello\Laraflash\Providers\LaraflashServiceProvider;

abstract class AbstractTestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaraflashServiceProvider::class,
        ];
    }

    public static function assertArraysSame($expected, $actual, $ignoreOrder = true)
    {
//        if ($ignoreOrder) {
//            Arr::sortRecursive();
//        }

        static::assertSame(
            Arr::sortRecursive($expected),
            Arr::sortRecursive($actual)
        );
    }
}
