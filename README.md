<p align="center"><img alt="Laraflash" src="https://i.imgur.com/qo7MxeN.png" width="380"></p>

<p align="center"><b>Laraflash</b> provides a handy way to work with the flash messages.</p>

<p align="center">
  <a href="https://github.com/coderello/laraflash/releases"><img src="https://img.shields.io/github/release/coderello/laraflash.svg?style=flat-square" alt="Latest Version"></a>
  <a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
  <a href="https://styleci.io/repos/149364639"><img src="https://styleci.io/repos/149364639/shield" alt="StyleCI"></a>
  <a href="https://scrutinizer-ci.com/g/coderello/laraflash"><img src="https://img.shields.io/scrutinizer/g/coderello/laraflash.svg?style=flat-square" alt="Quality Score"></a>
  <a href="https://scrutinizer-ci.com/g/coderello/laraflash/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/coderello/laraflash.svg?style=flat-square" alt="Coverage Status"></a>
</p>

## Install

You can install this package via composer using this command:

```bash
composer require coderello/laraflash 
```

After that you need to register the `\Coderello\Laraflash\Middleware\HandleLaraflash::class` middleware after the `\Illuminate\Session\Middleware\StartSession::class` one in the `app\Http\Kernel.php`

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laraflash-config"
```

## Adding flash messages

There are many syntax variations for adding flash messages, so you can choose the one you like the most.

Let's take a look at some of them.

```php
use Coderello\Laraflash\Facades\Laraflash;

Laraflash::message()->content('Some content')->title('Some title')->type('success');
```

> `message()` method creates and returns fresh `FlashMessage` instance which can be modified by chaining methods (all methods could be found in the `FlashMessage methods` section).

```php
laraflash()->message()->content('Some content')->title('Some title')->type('success');
```

> `Laraflash` facade can be replaced with the `laraflsh()` helper as you could saw in the example above.

```php
laraflash()->message('Some content', 'Some title')->success();
```

> `message()` method accepts up to five arguments: `$content`, `$title`, `$type`, `$delay`, `$hops`.

```php
laraflash('Some content', 'Some title')->success();
```

> Arguments mentioned in the previous example can be passed directly to the `laraflash()` helper.

## Rendering flash messages

Ready flash messages could be rendered using the `render()` method of the `Laraflash` instance.

```php
laraflash()->render();
```

> All methods of the `Laraflash` instance (which could be obtained by calling `laraflash()` helper without arguments being passed) could be found in the `Laraflash methods` section.

> Output HTML will be generated using skin, specified in the `laraflash.skin` config. All available skins are listed in the config file.

```html
<div class="alert alert-danger" role="alert">
   Danger message.
</div><br><div class="alert alert-info" role="alert">
   Info message.
</div>
```

> Default separator between the messages is the `<br>`, which is specified in the `laraflash.separator` config. Feel free to change it if you need.

Example of messages rendered as HTML:

![Example](example.png)

## Obtaining flash messages as an array

Flash messages can be obtained as an array using the `toArray()` method.

```php
laraflash()->toArray();
```

Here is the result:

```
[
  [
    "title" => null,
    "content" => "Instant message.",
    "type" => "danger",
    "hops" => 1,
    "delay" => 0,
  ],
]
```

> You can use array representation of flash messages for your API.

## `FlashMessage` methods

## `Laraflash` instance

## Testing

You can run the tests with:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
