<?php

namespace Coderello\Laraflash;

use ArrayAccess;
use Coderello\Laraflash\Exceptions\InvalidArgumentException;
use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Illuminate\Contracts\Support\Arrayable;

class FlashMessage implements Arrayable, ArrayAccess
{
    /**
     * @var array
     */
    const MUTABLE_PROPERTIES = ['title', 'content', 'type', 'hops', 'delay'];

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var int|null
     */
    protected $hops;

    /**
     * @var int|null
     */
    protected $delay;

    /**
     * FlashMessage constructor.
     */
    public function __construct()
    {
        $this->hops(1);

        $this->delay(1);
    }

    /**
     * Set the title for the current FlashMessage instance.
     *
     * @param string $title
     *
     * @return FlashMessage
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the content for the current FlashMessage instance.
     *
     * @param string $content
     *
     * @return FlashMessage
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the type for the current FlashMessage instance.
     *
     * @param string $type
     *
     * @return FlashMessage
     */
    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the hops amount for the current FlashMessage instance.
     *
     * @param int $hops
     *
     * @throws InvalidHopsAmountException
     *
     * @return FlashMessage
     */
    public function hops(int $hops): self
    {
        if ($hops < 1) {
            throw new InvalidHopsAmountException;
        }

        $this->hops = $hops;

        return $this;
    }

    /**
     * Set the delay for the current FlashMessage instance.
     *
     * @param int $delay
     *
     * @throws InvalidDelayException
     *
     * @return FlashMessage
     */
    public function delay(int $delay): self
    {
        if ($delay < 0) {
            throw new InvalidDelayException;
        }

        $this->delay = $delay;

        return $this;
    }

    /**
     * Show the message during the current request.
     *
     * @return FlashMessage
     */
    public function now(): self
    {
        $this->delay(0);

        return $this;
    }

    /**
     * Keep the message for one more request.
     *
     * @return FlashMessage
     */
    public function keep(): self
    {
        $this->hops++;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_reduce(self::MUTABLE_PROPERTIES, function (array $accumulator, string $property) {
            $accumulator[$property] = $this->{$property};

            return $accumulator;
        }, []);
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
        return $this->isMutableProperty($offset);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (! $this->isMutableProperty($offset)) {
            throw new InvalidArgumentException;
        }

        return $this->{$offset};
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (! $this->isMutableProperty($offset)) {
            throw new InvalidArgumentException;
        }

        $this->{$offset}($value);
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        //
    }

    /**
     * Whether a property is mutable.
     *
     * @param string $property
     *
     * @return bool
     */
    protected function isMutableProperty(string $property): bool
    {
        return in_array($property, self::MUTABLE_PROPERTIES);
    }
}