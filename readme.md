Laravel Matryoshka
================================================================================

[![Travis](https://img.shields.io/travis/sirthxalot/laravel-matryoshka.svg?maxAge=2592000)](https://travis-ci.org/sirthxalot/laravel-matryoshka)
[![GitHub issues](https://img.shields.io/github/issues/sirthxalot/laravel-matryoshka.svg)](https://github.com/sirthxalot/laravel-matryoshka/issues)
[![GitHub forks](https://img.shields.io/github/forks/sirthxalot/laravel-matryoshka.svg?style=social&label=Fork&maxAge=2592000)](https://github.com/sirthxalot/laravel-matryoshka)
[![GitHub stars](https://img.shields.io/github/stars/sirthxalot/laravel-matryoshka.svg?style=social&label=Star&maxAge=2592000)](https://github.com/sirthxalot/laravel-matryoshka)

[Laravel-Matryoshka](https://github.com/sirthxalot/laravel-matryoshka) is a simple 
package for [Laravel](https://laravel.com/) that provides Russian Doll caching for 
your view logic. It uses the "updated at" timestamp of the model, in order to automatic 
cache busting whenever the model is updated. Laravel-Matryoshka will extend your 
blade view logic in order to create caching segments, which can be managed separately.

Popularized in the Rails world, Russian Doll caching is an interesting approach, 
where you create nested fragment caches for your view logic. If you then link the 
keys for each of these cached items to the model's "updated at" timestamp, what 
you get is easy caching for your view logic, and automatic cache busting whenever 
the model is updated.

![laravel-matryoshka](https://cloud.githubusercontent.com/assets/6856248/22386827/21dbbc90-e4d9-11e6-9733-b89661e9d47c.png)


## How to install?

### Step-01: Composer

Use [Composer](https://getcomposer.org) from the command line and run:

```powerShell
composer require sirthxalot/laravel-matryoshka
```

### Step-02: Service Provider

Open `config/app.php`, and add a new item to the `providers` array:

```php
'providers' => [
    ...
    Sirthxalot\Cache\CacheServiceProvider::class,
    ...
]
```

This will bootstrap the Laravel-Matryoshka package into your Laravel application.

### Step-03: Setup Cache Driver

For this package to function properly, you must use a Laravel cache driver that 
supports tagging (like `Cache::tags('foo')`). Drivers such as [Memcached](http://memcached.org/) 
and [Redis](http://redis.io/) support this feature.

Check your `.env` file, and ensure that your `CACHE_DRIVER` choice accommodates 
this requirement:

```yml
CACHE_DRIVER=memcached
```

Have a look at [Laravel's cache configuration documentation](https://laravel.com/docs/5.2/cache#configuration), 
if you need any further help.


## Need Further Help

Please take a look at the [official documentation](https://sirthxalot.gitbooks.io/laravel-matryoshka/content/),
in order to receive further information about the Laravel-Matryoshka.
It will guide you through all the basics and is the defacto educational resource
specifically for any Laravel-Matryoshka beginner.

If you have a question, want to report any bug or have any other issue, than please
do not hesitate to use the [issue tracker](https://github.com/sirthxalot/laravel-matryoshka).
Here you will find any tickets, questions and many more, related to Laravel-Matryoshka.


## Contributing

Yet just me helped to get Laravel-Matryoshka what it is today, so lets 
change this. Anyone and everyone is welcome to contribute, however, if you decide 
to get involved, please take a moment to review the guidelines:

* [Bug reports](contributing.md#bug-reports)
* [Feature requests](contributing.md#feature-requests)
* [Pull requests](contributing.md#pull-requests)
* [GitFlow](contributing.md#the-gitflow-workflow)


## License

The code is available under the [MIT-License](license.md).
