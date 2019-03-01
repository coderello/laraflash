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

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laraflash-config"
```

## Few examples of typical use

### Adding the messages

You can add the flash message this way:

```php
laraflash('You have been registered successfully.')->success();
```

Of course, you are not limited to only one message. You can add any amount of messages.

The message added in the previous example will be available during the next request.
If you want your message to be ready during the current request, then you should chain the `->now()` method.

```php
laraflash('Instant message.')->danger()->now();
```

### Render ready messages as HTML

It's pretty easy to render messages as HTML. You just need to call `->render()` method on the `Laraflash` instance that is returned by the `laraflash()` helper.

```php
laraflash()->render();
```

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

### Getting ready messages as an array

You can get ready messages as an array this way:

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
