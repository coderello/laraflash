<?php

namespace Coderello\Laraflash;

use ArrayAccess;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;

class FlashMessagesBag implements ArrayAccess
{
    /**
     * An array for storing bag items.
     *
     * @var FlashMessage[]
     */
    protected $messages = [];

    /**
     * Create a new FlashMessage instance and put it in the bag.
     *
     * @param FlashMessage|null $message
     *
     * @return FlashMessage
     */
    public function add(?FlashMessage $message = null): FlashMessage
    {
        if (is_null($message)) {
            $message = new FlashMessage;
        }

        $this->messages[] = $message;

        return $message;
    }

    /**
     * Delete all instances of FlashMessage from the bag.
     *
     * @return FlashMessagesBag
     */
    public function clear(): self
    {
        $this->messages = [];

        return $this;
    }

    /**
     * Get all messages from the bag.
     *
     * @return FlashMessage[]
     */
    public function all()
    {
        return $this->messages;
    }

    /**
     * Get messages that should be displayed during the current request from the bag.
     *
     * @return FlashMessage[]
     */
    public function ready()
    {
        return array_filter($this->messages, function (FlashMessage $message) {
            return $message->toArray()['delay'] === 0;
        });
    }

    /**
     * Whether a offset exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->messages[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     *
     * @return FlashMessage
     */
    public function offsetGet($offset)
    {
        return $this->messages[$offset];
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param FlashMessage $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (! $value instanceof FlashMessage) {
            throw new InvalidArgumentException;
        }

        $this->messages[$offset] = $value;
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->messages[$offset]);
    }
}