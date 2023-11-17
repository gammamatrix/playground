# Playground

The Playground package.

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\ServiceProvider" --tag="playground-config"
```

You can publish the JS assets with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\ServiceProvider" --tag="playground-js"
```

Append an import, for playground, in the Laravel application `resources/js/app.js` file, under bootstrap:
```
import './bootstrap';

import './playground';
```


See the contents of the published config file: [config/playground.php](.config/playground.php)


## Configuration

All options are disabled by default.

Enable all options:

```
PLAYGROUND_LOAD_COMMANDS=true

PLAYGROUND_LOAD_ROUTES=true

PLAYGROUND_ROUTES_ABOUT=true
PLAYGROUND_ROUTES_BOOTSTRAP=true
PLAYGROUND_ROUTES_DASHBOARD=true
PLAYGROUND_ROUTES_HOME=true
PLAYGROUND_ROUTES_INDEX=true
PLAYGROUND_ROUTES_SITEMAP=true
PLAYGROUND_ROUTES_THEME=true
PLAYGROUND_ROUTES_WELCOME=true

PLAYGROUND_SITEMAP_ENABLE=true;
PLAYGROUND_SITEMAP_GUEST=true;
PLAYGROUND_SITEMAP_USER=true;

PLAYGROUND_PUBLISH_JS=true

PLAYGROUND_CDN=true
```

## Factories


```
cd database/factories


ln -snf ../../vendor/gammamatrix/playground/database/factories/GammaMatrix
```


## Testing

```bash
cd tests/Feature

ln -snf ../../vendor/gammamatrix/playground/testing/Feature Playground

cd tests/Unit

ln -snf ../../vendor/gammamatrix/playground/testing/Unit Playground
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
