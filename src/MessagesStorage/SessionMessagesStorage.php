<?php

namespace Coderello\Laraflash\MessagesStorage;

use Illuminate\Contracts\Session\Session;

class SessionMessagesStorage implements MessagesStorage
{
    protected $session;

    protected $sessionKey;

    public function __construct(Session $session, string $sessionKey = 'flash_messages')
    {
        $this->session = $session;

        $this->sessionKey = $sessionKey;
    }

    public function get(): array
    {
        return $this->session->get($this->sessionKey, []);
    }

    public function put(array $messages): void
    {
        $this->session->put($this->sessionKey, $messages);
    }
}