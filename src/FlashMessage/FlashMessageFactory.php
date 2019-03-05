<?php

namespace Coderello\Laraflash\FlashMessage;

use Illuminate\Container\Container;

class FlashMessageFactory implements FlashMessageFactoryContract
{
    protected $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
    }

    public function make(): FlashMessage
    {
        return $this->container->make(FlashMessage::class);
    }
}
