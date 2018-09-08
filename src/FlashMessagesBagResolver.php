<?php

namespace Coderello\Laraflash;

use Illuminate\Contracts\Session\Session;
use Coderello\Laraflash\Contracts\FlashMessagesBag;
use Coderello\Laraflash\Contracts\FlashMessagesBagResolver as FlashMessagesBagResolverContract;

class FlashMessagesBagResolver implements FlashMessagesBagResolverContract
{
    /**
     * FlashMessagesBag instance.
     *
     * @var FlashMessagesBag
     */
    protected $bag;

    /**
     * FlashMessagesBagPreparer constructor.
     *
     * @param Session $session
     * @param string $sessionKey
     */
    public function __construct(Session $session, string $sessionKey)
    {
        $bag = $session->get($sessionKey);

        if (is_null($bag) || ! is_object($bag) || ! $bag instanceof FlashMessagesBag) {
            $bag = app(FlashMessagesBag::class);

            $session->put($sessionKey, $bag);
        }

        $this->bag = $bag;
    }

    /**
     * Get FlashMessagesBag instance.
     *
     * @return FlashMessagesBag
     */
    public function bag(): FlashMessagesBag
    {
        return $this->bag;
    }
}
