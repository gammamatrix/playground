<?php
return [
    'cdn' => (boolean) env('PLAYGROUND_CDN', true),
    'layout' => (string) env('PLAYGROUND_LAYOUT', 'playground::layouts.site'),
    'js' => array_map('trim', explode(',', env('PLAYGROUND_JS', 'playground'))),
    'packages' => array_map('trim', explode(',', env('PLAYGROUND_PACKAGES', 'playground'))),
    'view' => (string) env('PLAYGROUND_VIEW', 'playground::'),
    'iframes' => (string) env('PLAYGROUND_IFRAMES', ''),
    'auth' => [
        // 'policy' => (string) env('PLAYGROUND_AUTH_POLICY', 'roles'),
        /**
         * Privileges checks in this order:
         * - Sanctum: HasApiTokens
         * - method_exists: hasPrivilege
         *
         * @var string $verify roles|privileges
         */
        'verify' => (string) env('PLAYGROUND_AUTH_VERIFY', 'privileges'),
        // 'verify' => (string) env('PLAYGROUND_AUTH_VERIFY', 'roles'),
        'hasPrivilege' => (bool) env('PLAYGROUND_AUTH_HAS_PRIVILEGE', false),
        'userPrivileges' => (bool) env('PLAYGROUND_AUTH_USER_PRIVILEGES', false),
        'hasRole' => (bool) env('PLAYGROUND_AUTH_HAS_ROLE', false),
        'userRoles' => (bool) env('PLAYGROUND_AUTH_USER_ROLES', false),
    ],
    'cache' => [
        'cms' => (string) env('PLAYGROUND_CACHE_CMS', 'file'),
        'cms_ttl' => (integer) env('PLAYGROUND_CACHE_CMS_TTL', 601),
        'security' => (string) env('PLAYGROUND_CACHE_SECURITY', 'file'),
        'security_ttl' => (integer) env('PLAYGROUND_CACHE_SECURITY_TTL', 597),
        'system' => (string) env('PLAYGROUND_CACHE_SYSTEM', 'file'),
        'system_ttl' => (integer) env('PLAYGROUND_CACHE_SYSTEM_TTL', 611),
        'purifier' => (string) env('PLAYGROUND_CACHE_PURIFIER', null),
    ],
    'load' => [
        // 'commands' => (boolean) env('PLAYGROUND_LOAD_COMMANDS', false),
        'routes' => (boolean) env('PLAYGROUND_LOAD_ROUTES', false),
        'views' => (boolean) env('PLAYGROUND_LOAD_VIEWS', false),
    ],
    'redirects' => [
        'dashboard' => (string) env('PLAYGROUND_REDIRECTS_DASHBOARD', '/dashboard'),
        'default' => (string) env('PLAYGROUND_REDIRECTS_DEFAULT', '/'),
        'home' => (string) env('PLAYGROUND_REDIRECTS_HOME', '/'),
        'logout' => (string) env('PLAYGROUND_REDIRECTS_LOGOUT', '/logout'),
    ],
    'routes' => [
        'about' => (boolean) env('PLAYGROUND_ROUTES_ABOUT', false),
        'bootstrap' => (boolean) env('PLAYGROUND_ROUTES_BOOTSTRAP', false),
        'dashboard' => (boolean) env('PLAYGROUND_ROUTES_DASHBOARD', false),
        'home' => (boolean) env('PLAYGROUND_ROUTES_HOME', false),
        'sitemap' => (boolean) env('PLAYGROUND_ROUTES_SITEMAP', false),
        'theme' => (boolean) env('PLAYGROUND_ROUTES_THEME', false),
        'welcome' => (boolean) env('PLAYGROUND_ROUTES_WELCOME', false),
    ],
    'dashboard' => [
        'enable' => (boolean) env('PLAYGROUND_DASHBOARD_ENABLE', false),
        'guest' => (boolean) env('PLAYGROUND_DASHBOARD_GUEST', false),
        'user' => (boolean) env('PLAYGROUND_DASHBOARD_USER', false),
        'view' => (string) env('PLAYGROUND_DASHBOARD_VIEW', 'playground::index.dashboard'),
    ],
    'sitemap' => [
        'enable' => (boolean) env('PLAYGROUND_SITEMAP_ENABLE', false),
        'guest' => (boolean) env('PLAYGROUND_SITEMAP_GUEST', false),
        'user' => (boolean) env('PLAYGROUND_SITEMAP_USER', false),
        'view' => (string) env('PLAYGROUND_SITEMAP_VIEW', 'playground::index.sitemap-playground'),
    ],
    'theme' => env('MIX_THEME', 'site'),

    /*
    |--------------------------------------------------------------------------
    | Software library versions and integrity verification.
    |--------------------------------------------------------------------------
    |
    | In order to trust 3rd party libraries have not been comprimised, we use
    | sha-256 integrity checks on local and CDN assets.
    |
    | NOTE When updating link and script assets, make sure to update the
    |      integrity with a SHA256 checksum.
    |
    | NOTE Use the npm version from package.json for each library.
    */

    'libs' => [
        'cdn' => [
            'ckeditor' => [
                'crossorigin' => 'anonymous',
                'integrity' => '',
                'url' => 'https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js',
                'version' => '34.2.0',
            ],
            'playground' => [
                'url' => '/vendor/playground.js',
                'version' => '1.0.0',
            ],
            // 'fontawesome' => [
            //     'crossorigin' => 'anonymous',
            //     'integrity' => 'sha256-k/BD5riVJWtbouHdLw+osR7VNosE40gZFNXjFHZAwzo=',
            //     'url' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/js/fontawesome.min.js',
            //     'version' => '4.5.0',
            // ],
            // 'fontawesome-css' => [
            //     'crossorigin' => 'anonymous',
            //     'integrity' => 'sha256-4w9DunooKSr3MFXHXWyFER38WmPdm361bQS/2KUWZbU=',
            //     'url' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/css/all.min.css',
            //     'version' => '5.12.0-1',
            // ],
            // 'gstatic' => [
            //     'version' => '',
            //     'integrity' => '',
            //     'url' => 'https://fonts.gstatic.com/',
            // ],
            // 'jquery' => [
            //     'crossorigin' => 'anonymous',
            //     'integrity' => 'sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=',
            //     'url' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js',
            //     'version' => '3.4.1',
            // ],
            // 'popper' => [
            //     'crossorigin' => 'anonymous',
            //     'integrity' => 'sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=',
            //     'url' => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js',
            //     'version' => '',
            // ],
            // 'moment' => [
            //     'crossorigin' => 'anonymous',
            //     'integrity' => 'sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=',
            //     'url' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js',
            //     'version' => '2.24.0',
            // ],
        ],
        'vendor' => [
            'ckeditor' => [
                // 'integrity' => 'sha256-O6msWr5chm3jMpzhL3leUj0C2d9lUx93b6CQF9KXciA=',
                'url' => 'https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js',
                // 'url' => '/vendor/ckeditor.js',
                'version' => '34.2.0',
            ],
            'playground' => [
                'url' => '/vendor/playground.js',
                'version' => '1.0.0',
            ],
            //     'fontawesome' => [
            //         'integrity' => 'sha256-kfloLmH/F2aW936XePvhgKlJH4TZMn/nAG5oxtuiy8Q=',
            //         'url' => '/vendor/fontawesome/js/fontawesome.min.js',
            //         'version' => '5.12.0',
            //     ],
            //     'fontawesome-css' => [
            //         'integrity' => 'sha256-ybRkN9dBjhcS2qrW1z+hfCxq+1aBdwyQM5wlQoQVt/0=',
            //         'url' => '/vendor/fontawesome/css/all.min.css',
            //         'version' => '5.12.0',
            //     ],
            //     'gstatic' => [
            //         'integrity' => '',
            //         'url' => '',
            //         'version' => '',
            //     ],
            //     'jquery' => [
            //         'integrity' => 'sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=',
            //         'url' => '/vendor/jquery.slim.min.js',
            //         'version' => '3.4.1',
            //     ],
            //     'popper' => [
            //         'integrity' => 'sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=',
            //         'url' => '/vendor/popper.min.js',
            //         'version' => '1.16.0',
            //     ],
            //     'moment' => [
            //         'integrity' => 'sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=',
            //         'url' => '/vendor/moment-with-locales.min.js',
            //         'version' => '2.24.0',
            //     ],
            // ],
        ],
    ],
];
