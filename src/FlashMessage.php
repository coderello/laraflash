<?php

namespace Coderello\Laraflash;

use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Illuminate\Contracts\Support\Arrayable;

class FlashMessage implements Arrayable
{
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
        return [
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'hops' => $this->hops,
            'delay' => $this->delay,
        ];
    }
}