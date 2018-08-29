<?php

namespace Coderello\Laraflash;

class FlashMessagesBagPreparer
{
    /**
     * @var FlashMessagesBag
     */
    protected $bag;

    /**
     * FlashMessagesBagPreparer constructor.
     *
     * @param FlashMessagesBag $bag
     */
    public function __construct(FlashMessagesBag $bag)
    {
        $this->bag = $bag;
    }

    /**
     * Prepare MessageBag before usage.
     *
     * @return void
     */
    public function prepare(): void
    {
        $messages = $this->bag->all();

        foreach ($messages as $key => $message) {
            $fields = $message->toArray();

            if ($fields['hops'] <= 1 && $fields['delay'] === 0) {
                unset($this->bag[$key]);

                continue;
            }

            if ($fields['hops'] > 1 && $fields['delay'] === 0) {
                $this->bag[$key]->hops($fields['hops'] - 1);

                continue;
            }

            if ($fields['delay'] > 0) {
                $this->bag[$key]->delay($fields['delay'] - 1);
            }
        }
    }
}
