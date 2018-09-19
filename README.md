<p align="center"><img alt="Laraflash" src="logo.png" width="380"></p>

<p align="center"><b>Laraflash</b> provides a handy way to work with the flash messages.</p>

## Installation

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
laraflash()
  ->add()
  ->content('You have been registered successfully.')
  ->type('success')
  ->important();
```

> You are calling the `->add()` method (that returns the new `FlashMessage` instance) on the `FlashMessagesBag` instance (that is returned by the `laraflash()` helper). All subsequent chained methods are called on the `FlashMessage` instance.

Of course, you are not limited to only one message. You can add any amount of messages.

The message added in the previous example will be available during the next request.
If you want your message to be ready during the current request, then you should chain the `->now()` method.

```php
laraflash()
  ->add()
  ->content('Instant message.')
  ->type('danger')
  ->now();
```

> Be sure to examine all available methods of the `FlashMessage` instance. They are listed below in the `FlashMessage methods` section.

### Render ready messages as HTML

It's pretty easy to render messages as HTML. You just need to call `->render()` method on the `FlashMessagesBag` instance that is returned by the `laraflash()` helper.

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
    "important" => false,
  ],
]

```

> Be sure to examine all available methods of the `FlashMessagesBag` instance. They are listed below in the `FlashMessagesBag methods` section.

## `FlashMessagesBag` methods

#### add(?FlashMessage $message = null)

Creates new `FlashMessage` instance or takes an existing one as the first param and adds it to the messages bag.

#### clear()

Deletes all messages from the bag.

#### keep()

Adds one more hop to each message in the bag.

#### all()

Returns all `FlashMessage` instances from the bag.

#### ready()

Returns ready `FlashMessage` instances (with `delay` equals to zero) from the bag.

#### prepare()

Prepares the bag (decrements amount of hops and delay, deletes expired messages).

#### render()

Renders the bag as HTML (calls the `->render()` method on each item of the bag and joins all rendered messages using the value of the `laraflash.separator` config as the separator). 

#### toJson()

Converts the bag to its JSON representation.

#### toArray()

Converts the bag to its array representation.

## `FlashMessage` methods

#### title(string $title)

Sets the title of the message.

#### content(string $content)

Sets the content of the message.

#### type(string $type)

Sets the type of the message.

#### hops(int $hops)

Sets the hops amount of the message (the number of requests in which the message will be present).
> Default: 1

#### delay(int $delay)

Sets the delay of the message (the number of requests in which the message will be waiting to receive the ready state).
> Default: 1

#### important(bool $important = true)

Sets the `important` flag for the message.
> Default: false

#### now()

Shortcut for `->delay(0)`

#### keep()

Increments the amount of hops.

#### render()

Renders the message as HTML using the value of the `laraflash.skin` config as the skin.

#### toJson()

Converts the message to its JSON representation.

#### toArray()

Converts the message to its array representation.

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
