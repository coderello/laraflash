<?php

namespace Coderello\Laraflash\FlashMessage;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;

class FlashMessage implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    /** @var string|null */
    protected $content;

    /** @var string|null */
    protected $title;

    /** @var string|null */
    protected $type;

    /** @var int|null */
    protected $hops = 1;

    /** @var int|null */
    protected $delay = 1;

    /** @var array */
    protected $attributes = [];

    public function content(?string $content): self
    {
        if (! is_null($content)) {
            $this->content = $content;
        } else {
            unset($this->content);
        }

        return $this;
    }

    public function title(?string $title): self
    {
        if (! is_null($title)) {
            $this->title = $title;
        } else {
            unset($this->title);
        }

        return $this;
    }

    public function type(?string $type): self
    {
        if (! is_null($type)) {
            $this->type = $type;
        } else {
            unset($this->type);
        }

        return $this;
    }

    public function danger(): self
    {
        $this->type('danger');

        return $this;
    }

    public function warning(): self
    {
        $this->type('warning');

        return $this;
    }

    public function info(): self
    {
        $this->type('info');

        return $this;
    }

    public function success(): self
    {
        $this->type('success');

        return $this;
    }

    public function hops(int $hops): self
    {
        if ($hops < 1) {
            throw new InvalidHopsAmountException;
        }

        $this->hops = $hops;

        return $this;
    }

    public function delay(int $delay): self
    {
        if ($delay < 0) {
            throw new InvalidDelayException;
        }

        $this->delay = $delay;

        return $this;
    }

    public function now(): self
    {
        $this->delay(0);

        return $this;
    }

    public function keep(): self
    {
        $this->hops++;

        return $this;
    }

    public function attribute(string $key, $value = null): self
    {
        if (! is_null($value)) {
            $this->attributes[$key] = $value;
        } else {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    public function get(string $key)
    {
        if (in_array($key, ['title', 'content', 'hops', 'delay', 'type'])) {
            return $this->{$key};
        }

        return $this->attributes[$key] ?? null;
    }

    public function toArray()
    {
        return array_merge(
            $this->attributes, [
                'content' => $this->content,
                'title' => $this->title,
                'type' => $this->type,
                'hops' => $this->hops,
                'delay' => $this->delay,
            ]
        );
    }

    public function toJson($options = 0)
    {
        return json_encode($this, $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->attribute($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attribute($name, $value);
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __unset($name)
    {
        unset($this->attributes[$name]);
    }
}
