# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jaybizzle/blade-protect.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/blade-protect)
[![Build Status](https://img.shields.io/travis/jaybizzle/blade-protect/master.svg?style=flat-square)](https://travis-ci.org/jaybizzle/blade-protect)
[![Quality Score](https://img.shields.io/scrutinizer/g/jaybizzle/blade-protect.svg?style=flat-square)](https://scrutinizer-ci.com/g/jaybizzle/blade-protect)
[![Total Downloads](https://img.shields.io/packagist/dt/jaybizzle/blade-protect.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/blade-protect)


Prevent concurrent edits of the same resource by multiple users.

## Installation

You can install the package via composer:

```bash
composer require jaybizzle/blade-protect
```

```
php artisan vendor:publish --provider="Jaybizzle\BladeProtect\BladeProtectServiceProvider" --tag="migrations"
```
After the migration has been published you can create the `protected` table by running the migrations:

```
php artisan migrate
```

```
php artisan vendor:publish --provider="Jaybizzle\BladeProtect\BladeProtectServiceProvider" --tag="public" --force
```

## Usage

```blade
@protect('user-edit-form', $user->id)

@ifprotected('user-edit-form', $user->id)
    <p>This user cannot be edited becuase another admin is already editing this user</p>
@endprotected
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mbeech@mark-beech.co.uk instead of using the issue tracker.


## Credits

- [Mark Beech](https://github.com/JayBizzle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
