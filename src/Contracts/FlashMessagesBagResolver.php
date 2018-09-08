<?php

namespace Coderello\Laraflash\Contracts;

use Illuminate\Contracts\Session\Session;

interface FlashMessagesBagResolver
{
    public function __construct(Session $session, string $sessionKey);

    public function bag(): FlashMessagesBag;
}
