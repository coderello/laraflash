<?php

namespace Coderello\Laraflash\Tests\Support;

use Illuminate\Contracts\View\Factory;

class ViewFactory implements Factory
{
    const MADE_CONTENT = 'MADE CONTENT';

    public $exists = true;

    public function exists($view)
    {
        return $this->exists;
    }

    public function file($path, $data = [], $mergeData = [])
    {
        //
    }

    public function make($view, $data = [], $mergeData = [])
    {
        return self::MADE_CONTENT;
    }

    public function share($key, $value = null)
    {
        //
    }

    public function composer($views, $callback)
    {
        //
    }

    public function creator($views, $callback)
    {
        //
    }

    public function addNamespace($namespace, $hints)
    {
        //
    }

    public function replaceNamespace($namespace, $hints)
    {
        //
    }
}
