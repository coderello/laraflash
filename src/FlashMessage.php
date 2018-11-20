<?php

namespace Coderello\Laraflash;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Coderello\Laraflash\Events\FlashMessageCreated;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Coderello\Laraflash\Exceptions\InvalidDelayException;
use Coderello\Laraflash\Exceptions\SkinNotFoundException;
use Coderello\Laraflash\Exceptions\InvalidHopsAmountException;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class FlashMessage implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, Renderable, Htmlable
{
    /** @var Application */
    protected $app;

    /** @var array */
    protected $attributes = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->hops(1);

        $this->delay(1);

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->app->make(EventDispatcher::class);

        $eventDispatcher->dispatch(new FlashMessageCreated($this));
    }

    public static function attributesThatShouldNotBeStoredDirectly(): array
    {
        return ['content', 'title', 'type', 'hops', 'delay'];
    }

    public function content(?string $content): self
    {
        $this->setAttribute('content', $content);

        return $this;
    }

    public function title(?string $title): self
    {
        $this->setAttribute('title', $title);

        return $this;
    }

    public function type(?string $type): self
    {
        $this->setAttribute('type', $type);

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

        $this->setAttribute('hops', $hops);

        return $this;
    }

    public function delay(int $delay): self
    {
        if ($delay < 0) {
            throw new InvalidDelayException;
        }

        $this->setAttribute('delay', $delay);

        return $this;
    }

    public function now(): self
    {
        $this->delay(0);

        return $this;
    }

    public function keep(): self
    {
        $this->setAttribute('hops', $this->getAttribute('hops') + 1);

        return $this;
    }

    public function attribute(string $key, $value): self
    {
        if (in_array($key, static::attributesThatShouldNotBeStoredDirectly())) {
            $this->{$key}($value);
        } else {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    protected function setAttribute(string $key, $value): self
    {
        if (! is_null($value)) {
            $this->attributes[$key] = $value;
        } else {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    protected function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    protected function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
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
        /** @var ViewFactory $viewFactory */
        $viewFactory = $this->app->make(ViewFactory::class);

        /** @var ConfigRepository $configRepository */
        $configRepository = $this->app->make(ConfigRepository::class);

        $skin = $configRepository->get('laraflash.skin');

        if (! $viewFactory->exists($skin)) {
            throw new SkinNotFoundException($skin);
        }

        return $viewFactory->make($skin, $this->getAttributes())->render();
    }

    public function render()
    {
        return $this->toHtml();
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
