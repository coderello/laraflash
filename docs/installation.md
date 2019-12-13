---
title: Installation
section: Getting Started
weight: 1000
featherIcon: download
---

## Basic installation

You can install this package via composer using this command:

```bash
composer require coderello/laraflash 
```

After that you need to register the `\Coderello\Laraflash\Middleware\HandleLaraflash::class` middleware after the `\Illuminate\Session\Middleware\StartSession::class` one in the `app\Http\Kernel.php`

> {danger} Package will not work properly without the middleware registration.

## Publishing the config

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laraflash-config"
```
