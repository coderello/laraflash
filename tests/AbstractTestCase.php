<?php

namespace Coderello\Laraflash\Tests;

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
}
