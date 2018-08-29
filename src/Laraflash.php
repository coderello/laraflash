<?php

namespace Coderello\Laraflash;

class Laraflash
{
    /**
     * @var FlashMessagesBag
     */
    protected $bag;

    /**
     * Laraflash constructor.
     */
    public function __construct()
    {
        $this->bag = app()->make(FlashMessagesBag::class);
    }

    /**
     * @return FlashMessagesBag
     */
    public function bag(): FlashMessagesBag
    {
        return $this->bag;
    }

    /**
     * A shortcut for the add() method of the bag.
     *
     * @param FlashMessage|null $message
     *
     * @return FlashMessage
     */
    public function add(?FlashMessage $message = null): FlashMessage
    {
        return $this->bag->add($message);
    }

    /**
     * A shortcut for the all() method of the bag.
     *
     * @return FlashMessage[]
     */
    public function all(): array
    {
        return $this->bag->all();
    }

    /**
     * A shortcut for the ready() method of the bag.
     *
     * @return FlashMessage[]
     */
    public function ready(): array
    {
        return $this->bag->ready();
    }
}
