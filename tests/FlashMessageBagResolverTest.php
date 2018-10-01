<?php

namespace Coderello\Laraflash\Tests;

use DateTime;
use Coderello\Laraflash\FlashMessagesBag;
use Illuminate\Contracts\Session\Session;
use Coderello\Laraflash\FlashMessagesBagResolver;
use Coderello\Laraflash\Contracts\FlashMessagesBagResolver as FlashMessagesBagResolverContract;

class FlashMessageBagResolverTest extends AbstractTestCase
{
    protected $sessionKey = 'flash_messages_bag';

    public function test_implements_contract()
    {
        $session = app(Session::class);

        $this->assertTrue(new FlashMessagesBagResolver($session, $this->sessionKey) instanceof FlashMessagesBagResolverContract);
    }

    public function test_bag_resolving_with_null_value_in_session()
    {
        $session = app()->make(Session::class);

        session()->put($this->sessionKey, null);

        $resolver = new FlashMessagesBagResolver(
            $session,
            $this->sessionKey
        );

        $this->assertTrue($resolver->bag() instanceof FlashMessagesBag);

        $this->assertSame($resolver->bag(), $session->get($this->sessionKey));
    }

    public function test_bag_resolving_with_wrong_object_in_session()
    {
        $session = app()->make(Session::class);

        session()->put($this->sessionKey, new DateTime());

        $resolver = new FlashMessagesBagResolver(
            $session,
            $this->sessionKey
        );

        $this->assertTrue($resolver->bag() instanceof FlashMessagesBag);

        $this->assertSame($resolver->bag(), $session->get($this->sessionKey));
    }

    public function test_bag_resolving_with_correct_object_in_session()
    {
        $session = app()->make(Session::class);

        $bag = new FlashMessagesBag();

        session()->put($this->sessionKey, $bag);

        $resolver = new FlashMessagesBagResolver(
            $session,
            $this->sessionKey
        );

        $this->assertTrue($resolver->bag() instanceof FlashMessagesBag);

        $this->assertSame($bag, $resolver->bag());

        $this->assertSame($bag, $session->get($this->sessionKey));
    }
}
