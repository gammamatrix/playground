# Playground

[![Playground CI Workflow](https://github.com/gammamatrix/playground/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground/testing/develop/coverage.svg)](tests)

This is the base package for Playground.

This package provides controllers, policies, migrations, models, requests, views and more for building [Laravel](https://laravel.com/docs/10.x) packages.
- Playground defaults to using [Laravel ordered UUIDs](https://laravel.com/docs/10.x/strings#method-str-ordered-uuid) for primary keys.
- The configuration in Playground and subpackages permits defining the user model, table and primary key type: `increments` or `uuid`.
- Packages are compatible and tested with and without: middleware, roles, policies, privileges, Sanctum...

Read more on using Playground with available packages [on the Playground wiki.](https://github.com/gammamatrix/playground/wiki)

Using Blade for the UI is optional, any frontend should be able to work with endpoints using JSON.

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

### Environment Variables

#### Authentication and Authorization

| env()                             | config()                         |
|-----------------------------------|----------------------------------|
| `PLAYGROUND_USER`                 | `playground.user`                |
| `PLAYGROUND_USER_ID`              | `playground.user_id`             |
| `PLAYGROUND_USER_TABLE`           | `playground.user_table`          |
| `PLAYGROUND_AUTH_VERIFY`          | `playground.auth.verify`         |
| `PLAYGROUND_AUTH_HAS_PRIVILEGE`   | `playground.auth.hasPrivilege`   |
| `PLAYGROUND_AUTH_USER_PRIVILEGES` | `playground.auth.userPrivileges` |
| `PLAYGROUND_AUTH_HAS_ROLE`        | `playground.auth.hasRole`        |
| `PLAYGROUND_AUTH_USER_ROLE`       | `playground.auth.hasRole`        |
| `PLAYGROUND_AUTH_USER_ROLES`      | `playground.auth.userRoles`      |

#### Loading

| env()                    | config()                 |
|--------------------------|--------------------------|
| `PLAYGROUND_LOAD_ROUTES` | `playground.load.routes` |
| `PLAYGROUND_LOAD_VIEWS`  | `playground.load.views`  |

`PLAYGROUND_LOAD_ROUTES` must be enabled to load the routes in the application (unless published to your app - the control for this is in the [ServiceProvider.php](src/ServiceProvider.php))

#### Routes

All routes are disabled by default in the base Playground package.

| env()                         | config()                      |
|-------------------------------|-------------------------------|
| `PLAYGROUND_ROUTES_ABOUT`     | `playground.routes.about`     |
| `PLAYGROUND_ROUTES_BOOTSTRAP` | `playground.routes.bootstrap` |
| `PLAYGROUND_ROUTES_DASHBOARD` | `playground.routes.dashboard` |
| `PLAYGROUND_ROUTES_HOME`      | `playground.routes.home`      |
| `PLAYGROUND_ROUTES_SITEMAP`   | `playground.routes.sitemap`   |
| `PLAYGROUND_ROUTES_THEME`     | `playground.routes.theme`     |
| `PLAYGROUND_ROUTES_WELCOME`   | `playground.routes.welcome`   |

### UI

| env()                         | config()                      |
|-------------------------------|-------------------------------|
| `PLAYGROUND_LAYOUT`           | `playground.layout`           |
| `PLAYGROUND_VIEW`             | `playground.view`             |
| `PLAYGROUND_PACKAGES`         | `playground.packages`         |
| `PLAYGROUND_DASHBOARD_ENABLE` | `playground.dashboard.enable` |
| `PLAYGROUND_DASHBOARD_GUEST`  | `playground.dashboard.guest`  |
| `PLAYGROUND_DASHBOARD_USER`   | `playground.dashboard.user`   |
| `PLAYGROUND_DASHBOARD_VIEW`   | `playground.dashboard.view`   |
| `PLAYGROUND_SITEMAP_ENABLE`   | `playground.sitemap.enable`   |
| `PLAYGROUND_SITEMAP_GUEST`    | `playground.sitemap.guest`    |
| `PLAYGROUND_SITEMAP_USER`     | `playground.sitemap.user`     |
| `PLAYGROUND_SITEMAP_VIEW`     | `playground.sitemap.view`     |


## UI Layouts

NOTE: Using Blade is not required to use Playground, it just an option, such as Vue, React or TypeScript.

The configuration in [config/playground.php](config/playground.php) has a section for frontend assets. If you would like to add more assets, CSS or JavaScript, publish the configuration and add them to the `libs` section.

Assets may be loaded into either head or they will be added to the end of the body.

By default, the following libraries are loaded.

- `favicon`: `/favicon.ico`
- [Nunito](https://fonts.google.com/specimen/Nunito): Loaded from Google Fonts.
- [Bootstrap: 5.3.2](https://getbootstrap.com/docs/5.3/)
- [FontAwesome: 6.4.2](https://fontawesome.com/search?o=r&m=free)
- [Vue 3 - https://unpkg.com/vue@3](https://vuejs.org/)
- `/vendor/playground.js` A small library to be loaded for Blade UI usage. Needs to be published.

Optionally, a page may load:
- [CKEditor 5](https://ckeditor.com/ckeditor-5/) an advanced WYSIWYG editor for forms.


### Assets

If you are using the Playground Blade UI, you can publish the JS assets with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\ServiceProvider" --tag="playground-js"
```
- These Javascript assets, [resources/js/playground.js](resources/js/playground.js), provide simple helpers for features such as Bootstrap Form Validation and loading CKEditor for textarea elements on forms.


## Migrations

The migrations provided in this package are used for [PHPunit 10](https://docs.phpunit.de/en/10.4/) feature testing with [Orchestra Testbench](https://packages.tools/testbench.html).
- They will not be exported in software builds.

## Testing

```sh
composer test
```

## About

Playground provides information in the `artisan about` command.

<img src="resources/docs/artisan-about-playground.png" alt="screenshot of artisan about command with Playground.">

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
