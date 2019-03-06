# Easily manage addresses in your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/signifly/laravel-addresses.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-addresses)
[![Build Status](https://img.shields.io/travis/signifly/laravel-addresses/master.svg?style=flat-square)](https://travis-ci.org/signifly/laravel-addresses)
[![StyleCI](https://styleci.io/repos/166245153/shield?branch=master)](https://styleci.io/repos/166245153)
[![Quality Score](https://img.shields.io/scrutinizer/g/signifly/laravel-addresses.svg?style=flat-square)](https://scrutinizer-ci.com/g/signifly/laravel-addresses)
[![Total Downloads](https://img.shields.io/packagist/dt/signifly/laravel-addresses.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-addresses)

The `signifly/laravel-addresses` package allows you to easily mange addresses in your Laravel app.

## Documentation
Until further documentation is provided, please have a look at the tests.

You can install the package via composer:

``` bash
composer require signifly/laravel-addresses
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Signifly\Addresses\AddressesServiceProvider" --tag="migrations"
```

After publishing the migration you can create the `addresses` table by running the migrations:


```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Signifly\Addresses\AddressesServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
     * The address model.
     */
    'address_model' => \Signifly\Addresses\Models\Address::class,

    /*
     * The name of the table.
     */
    'table_name' => 'addresses',
];
```

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
