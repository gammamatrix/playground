# Playground

[![Playground CI Workflow](https://github.com/gammamatrix/playground/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground/testing/develop/coverage.svg)](tests)
[![PHPStan Level 2 src and tests](https://img.shields.io/badge/PHPStan-level%202-brightgreen)](.github/workflows/ci.yml#L128)

This is the base package for Playground.

This package provides model handling for [Laravel](https://laravel.com/docs/11.x) packages.
- Playground allows using [Laravel ordered UUIDs](https://laravel.com/docs/11.x/strings#method-str-ordered-uuid) for primary keys.
- The configuration in Playground and subpackages permits defining the user model, table and primary key type: `increments` or `uuid`.
- Packages are compatible and tested with and without: middleware, roles, policies, privileges, Sanctum...

Read more on using Playground [at the Read the Docs for Playground.](https://gammamatrix-playground.readthedocs.io/)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground
```

## Configuration

You can publish the configuration file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground.php](config/playground.php)

## `artisan about`

Playground provides information in the `artisan about` command.

<img src="resources/docs/artisan-about-playground.png" alt="screenshot of artisan about command with Playground.">


### Environment Variables

|  env()                              | config()                            |
|-------------------------------------|-------------------------------------|
| `PLAYGROUND_LOAD_MIGRATIONS` | `playground.load.migrations` |
- The loading option for migrations does not take effect if the migrations have been exported to your app. The control for loading is handled in the package [ServiceProvider.](src/ServiceProvider.php)


## Migrations

The migrations provided in this package are used for [PHPunit 11](https://docs.phpunit.de/en/11.0/) feature testing with [Orchestra Testbench](https://packages.tools/testbench.html).
- They will not be exported in software builds.

## Cloc

```sh
composer cloc
```

```
➜  playground git:(develop) ✗ composer cloc
> cloc --exclude-dir=output,vendor .
      98 text files.
      62 unique files.
      38 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.11 s (582.6 files/s, 57515.8 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
PHP                             52            921            856           3591
YAML                             1              5              0            275
XML                              3              0              9            222
JSON                             2              0              0            103
Markdown                         3             42              0             82
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                            62            971            865           4285
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
