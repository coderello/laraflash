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
     * Add one hop to each message.
     *
     * @return FlashMessagesBag
     */
    public function keep(): self
    {
        foreach ($this->messages as $message) {
            $message->keep();
        }

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
     * Prepare the bag before use (decrement amount of hops and delay, delete expired messages).
     *
     * @return FlashMessagesBag
     */
    public function prepare(): self
    {
        foreach ($this->messages as $key => $message) {
            if ($message['hops'] <= 1 && $message['delay'] === 0) {
                unset($this->messages[$key]);

                continue;
            }

            if ($message['hops'] > 1 && $message['delay'] === 0) {
                $message->hops($message['hops'] - 1);

                continue;
            }

            if ($message['delay'] > 0) {
                $message->delay($message['delay'] - 1);
            }
        }

        return $this;
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