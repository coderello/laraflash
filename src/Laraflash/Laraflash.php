<?php

namespace Coderello\Laraflash\Laraflash;

use ArrayAccess;
use JsonSerializable;
use BadMethodCallException;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Coderello\Laraflash\FlashMessage\FlashMessage;
use Coderello\Laraflash\MessagesStorage\MessagesStorageContract;
use Coderello\Laraflash\FlashMessage\FlashMessageFactoryContract;

class Laraflash implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, Renderable, Htmlable
{
    /** @var Collection */
    protected $messages;

    protected $flashMessageFactory;

    protected $messagesStorage;

    protected $laraflashRenderer;

    public function __construct(FlashMessageFactoryContract $flashMessageFactory, MessagesStorageContract $messagesStorage, LaraflashRendererContract $laraflashRenderer)
    {
        $this->flashMessageFactory = $flashMessageFactory;

        $this->messagesStorage = $messagesStorage;

        $this->laraflashRenderer = $laraflashRenderer;

        $this->messages = Collection::make();
    }

    public function load(): self
    {
        $this->messages = Collection::make($this->messagesStorage->get())
            ->whereInstanceOf(FlashMessage::class);

        return $this;
    }

    public function save(): self
    {
        $this->messagesStorage->put($this->messages->all());

        return $this;
    }

    public function message(?string $content = null, ?string $title = null, ?string $type = null, ?int $delay = null, ?int $hops = null): FlashMessage
    {
        $message = $this->flashMessageFactory->make();

        if (! is_null($content)) {
            $message->content($content);
        }

        if (! is_null($title)) {
            $message->title($title);
        }

        if (! is_null($type)) {
            $message->type($type);
        }

        if (! is_null($delay)) {
            $message->delay($delay);
        }

        if (! is_null($hops)) {
            $message->hops($hops);
        }

        $this->messages->push($message);

        return $message;
    }

    public function keep(): self
    {
        $this->messages->each(function (FlashMessage $message) {
            $message->keep();
        });

        return $this;
    }

    public function clear(): self
    {
        $this->messages = Collection::make();

        return $this;
    }

    public function all(): Collection
    {
        return Collection::make($this->messages);
    }

    public function ready(): Collection
    {
        return $this->messages
            ->filter(function (FlashMessage $message) {
                return $message->get('delay') === 0;
            });
    }

    public function touch(): self
    {
        $this->messages = $this->messages->reject(function (FlashMessage $message) {
            return $message->get('hops') <= 1 && $message->get('delay') === 0;
        })->each(function (FlashMessage $message) {
            if ($message->get('hops') > 1 && $message->get('delay') === 0) {
                $message->hops($message->get('hops') - 1);
            } elseif ($message->get('delay') > 0) {
                $message->delay($message->get('delay') - 1);
            }
        });

        return $this;
    }

    public function toArray()
    {
        return $this->ready()->map(function (FlashMessage $message) {
            return $message->toArray();
        })->values()->all();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this, $options);
    }

    public function offsetExists($offset)
    {
        return $this->messages->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->messages->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException;
    }

    public function offsetUnset($offset)
    {
        $this->messages->forget($offset);
    }

    public function toHtml()
    {
        return $this->render();
    }

    public function render()
    {
        return $this->laraflashRenderer->render($this);
    }
}
