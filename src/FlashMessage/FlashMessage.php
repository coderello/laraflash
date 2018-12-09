<?php

namespace Coderello\Laraflash\FlashMessage;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;

class FlashMessage implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, Renderable, Htmlable
{
    /** @var array */
    protected $attributes = [];

    protected $flashMessageRenderer;

    public function __construct(FlashMessageRendererContract $flashMessageRenderer)
    {
        $this->flashMessageRenderer = $flashMessageRenderer;

        $this->hops(1);

        $this->delay(1);
    }

    public static function attributesThatShouldNotBeStoredDirectly(): array
    {
        return ['content', 'title', 'type', 'hops', 'delay'];
    }

    public function content(?string $content): self
    {
        $this->setAttributeDirectly('content', $content);

        return $this;
    }

    public function title(?string $title): self
    {
        $this->setAttributeDirectly('title', $title);

        return $this;
    }

    public function type(?string $type): self
    {
        $this->setAttributeDirectly('type', $type);

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

        $this->setAttributeDirectly('hops', $hops);

        return $this;
    }

    public function delay(int $delay): self
    {
        if ($delay < 0) {
            throw new InvalidDelayException;
        }

        $this->setAttributeDirectly('delay', $delay);

        return $this;
    }

    public function now(): self
    {
        $this->delay(0);

        return $this;
    }

    public function keep(): self
    {
        $this->setAttributeDirectly('hops', $this->getAttribute('hops') + 1);

        return $this;
    }

    public function attribute(string $key, $value): self
    {
        $this->setAttribute($key, $value);

        return $this;
    }

    protected function setAttributeDirectly(string $key, $value): self
    {
        if (! is_null($value)) {
            $this->attributes[$key] = $value;
        } else {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    protected function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function setAttribute(string $key, $value)
    {
        if (in_array($key, static::attributesThatShouldNotBeStoredDirectly())) {
            $this->{$key}($value);
        } else {
            $this->setAttributeDirectly($key, $value);
        }
    }

    public function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function toArray()
    {
        return $this->getAttributes();
    }

    public function toJson($options = 0)
    {
        return json_encode($this, $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toHtml()
    {
        return $this->render();
    }

    public function render()
    {
        return $this->flashMessageRenderer->render($this);
    }

    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->attribute($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->attribute($offset, null);
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        $this->attribute($name, $value);
    }

    public function __isset($name)
    {
        return $this->hasAttribute($name);
    }
}
