<?php

namespace Coderello\Laraflash;

use Throwable;
use Coderello\Laraflash\Contracts\FlashMessage;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;
use Coderello\Laraflash\Contracts\FlashMessagesBag as FlashMessagesBagContract;

class FlashMessagesBag implements FlashMessagesBagContract
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
            $message = app(FlashMessage::class);
        }

        $this->messages[] = $message;

        return $message;
    }

    /**
     * Delete all instances of FlashMessage from the bag.
     *
     * @return FlashMessagesBagContract
     */
    public function clear(): FlashMessagesBagContract
    {
        $this->messages = [];

        return $this;
    }

    /**
     * Add one hop to each message.
     *
     * @return FlashMessagesBagContract
     */
    public function keep(): FlashMessagesBagContract
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
    public function all(): array
    {
        return $this->messages;
    }

    /**
     * Get messages that should be displayed during the current request from the bag.
     *
     * @return FlashMessage[]
     */
    public function ready(): array
    {
        return array_filter($this->messages, function (FlashMessage $message) {
            return $message->toArray()['delay'] === 0;
        });
    }

    /**
     * Prepare the bag before use (decrement amount of hops and delay, delete expired messages).
     *
     * @return FlashMessagesBagContract
     */
    public function prepare(): FlashMessagesBagContract
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
     * Get the evaluated contents of the object.
     *
     * @return string
     *
     * @throws Throwable
     */
    public function render(): string
    {
        return implode(config('laraflash.separator'), array_map(function (FlashMessage $message) {
            return $message->render();
        }, $this->ready()));
    }

    /**
     * Data which should be serialized to JSON.
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this, $options);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_values(array_map(function (FlashMessage $message) {
            return $message->toArray();
        }, $this->ready()));
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
