<?php

namespace Coderello\Laraflash\Tests;

use Illuminate\Support\Facades\Request;
use Coderello\Laraflash\Laraflash\Laraflash;
use Coderello\Laraflash\Laraflash\LaraflashPreparer;
use Coderello\Laraflash\Tests\Support\MessagesStorage;
use Coderello\Laraflash\Tests\Support\LaraflashRenderer;
use Coderello\Laraflash\Tests\Support\FlashMessageFactory;

class LaraflashPreparerTest extends AbstractTestCase
{
    /** @var Laraflash */
    protected $laraflash;

    /** @var LaraflashPreparer */
    protected $laraflashPreparer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->laraflash = new Laraflash(
            new FlashMessageFactory,
            new MessagesStorage,
            new LaraflashRenderer
        );

        $this->laraflashPreparer = new LaraflashPreparer;
    }

    public function testHandleMethod()
    {
        $this->laraflash->message()->delay(2)->hops(2);

        foreach ([[2, 2], [1, 2], [0, 2], [0, 1]] as $values) {
            $this->assertSame($values[0], $this->laraflash->all()->first()->get('delay'));
            $this->assertSame($values[1], $this->laraflash->all()->first()->get('hops'));

            $this->laraflashPreparer->handle(
                $this->laraflash,
                Request::instance()
            );
        }

        $this->assertSame(0, $this->laraflash->all()->count());
    }
}
