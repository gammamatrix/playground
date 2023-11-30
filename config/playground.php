<?php

return [
    'user' => (string) env('PLAYGROUND_USER', 'App\\Models\\User'),
    'user_id' => (string) env('PLAYGROUND_USER_ID', 'increments'),
    'user_table' => (string) env('PLAYGROUND_USER_TABLE', 'users'),
    'layout' => (string) env('PLAYGROUND_LAYOUT', 'playground::layouts.site'),
    'packages' => array_map('trim', explode(',', env('PLAYGROUND_PACKAGES', 'playground'))),
    'view' => (string) env('PLAYGROUND_VIEW', 'playground::'),
    'auth' => [
        /**
         * Privileges checks in this order:
         * - Sanctum: HasApiTokens
         * - method_exists: hasPrivilege
         *
         * @var string $verify roles|privileges
         */
        'verify' => (string) env('PLAYGROUND_AUTH_VERIFY', 'privileges'),
        // 'verify' => (string) env('PLAYGROUND_AUTH_VERIFY', 'roles'),
        'token' => [
            'name' => 'app',
        ],
        'hasPrivilege' => (bool) env('PLAYGROUND_AUTH_HAS_PRIVILEGE', false),
        'userPrivileges' => (bool) env('PLAYGROUND_AUTH_USER_PRIVILEGES', false),
        'hasRole' => (bool) env('PLAYGROUND_AUTH_HAS_ROLE', false),
        'userRole' => (bool) env('PLAYGROUND_AUTH_USER_ROLE', false),
        'userRoles' => (bool) env('PLAYGROUND_AUTH_USER_ROLES', false),
    ],
    'date' => [
        'sql' => (string) env('PLAYGROUND_DATE_MYSQL', 'Y-m-d H:i:s'),
    ],
    'load' => [
        'routes' => (bool) env('PLAYGROUND_LOAD_ROUTES', false),
        'views' => (bool) env('PLAYGROUND_LOAD_VIEWS', false),
    ],
    'purifier' => [
        'iframes' => (string) env(
            'PLAYGROUND_PURIFIER_IFRAMES',
            '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%'
        ),
        'path' => (string) env('PLAYGROUND_PURIFIER_PATH', ''),
    ],
    'routes' => [
        'about' => (bool) env('PLAYGROUND_ROUTES_ABOUT', false),
        'bootstrap' => (bool) env('PLAYGROUND_ROUTES_BOOTSTRAP', false),
        'dashboard' => (bool) env('PLAYGROUND_ROUTES_DASHBOARD', false),
        'home' => (bool) env('PLAYGROUND_ROUTES_HOME', false),
        'sitemap' => (bool) env('PLAYGROUND_ROUTES_SITEMAP', false),
        'theme' => (bool) env('PLAYGROUND_ROUTES_THEME', false),
        'welcome' => (bool) env('PLAYGROUND_ROUTES_WELCOME', false),
    ],
    'dashboard' => [
        'enable' => (bool) env('PLAYGROUND_DASHBOARD_ENABLE', false),
        'guest' => (bool) env('PLAYGROUND_DASHBOARD_GUEST', false),
        'user' => (bool) env('PLAYGROUND_DASHBOARD_USER', false),
        'view' => (string) env('PLAYGROUND_DASHBOARD_VIEW', 'playground::index.dashboard'),
    ],
    'sitemap' => [
        'enable' => (bool) env('PLAYGROUND_SITEMAP_ENABLE', false),
        'guest' => (bool) env('PLAYGROUND_SITEMAP_GUEST', false),
        'user' => (bool) env('PLAYGROUND_SITEMAP_USER', false),
        'view' => (string) env('PLAYGROUND_SITEMAP_VIEW', 'playground::index.sitemap-playground'),
    ],
    'themes' => [
        'default' => [
            'enable' => (bool) env('PLAYGROUND_THEME_DEFAULT_ENABLE', true),
            'label' => 'Default Theme',
            'key' => '',
            'icon' => '',
        ],
        'dark' => [
            'enable' => (bool) env('PLAYGROUND_THEME_DARK_ENABLE', true),
            'label' => 'Dark Theme',
            'key' => 'dark',
            'icon' => 'fa-solid fa-moon',
        ],
        'light' => [
            'enable' => (bool) env('PLAYGROUND_THEME_LIGHT_ENABLE', true),
            'label' => 'Light Theme',
            'key' => 'light',
            'icon' => 'fa-solid fa-sun',
        ],
    ],
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
    */
    'libs' => [
        'head' => [
            'favicon' => [
                'type' => 'link',
                'href' => '/favicon.ico',
                'rel' => 'icon',
                'always' => true,
            ],
            // 'gstatic' => [
            //     'type' => 'link',
            //     'version' => '',
            //     'integrity' => '',
            //     'href' => 'https://fonts.gstatic.com/',
            // ],
            'nunito' => [
                'type' => 'link',
                'href' => 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap',
                'rel' => 'stylesheet',
                'always' => true,
            ],
            'body-nunito' => [
                'type' => 'style',
                'style' => 'body {font-family: Nunito, sans-serif;}',
                'always' => true,
            ],
            'ckeditor' => [
                'type' => 'script',
                'crossorigin' => 'anonymous',
                'integrity' => '',
                'src' => 'https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js',
                'version' => '34.2.0',
            ],
            'bootstrap-css' => [
                'rel' => 'stylesheet',
                'type' => 'link',
                'crossorigin' => 'anonymous',
                'integrity' => 'sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN',
                'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
                'version' => '5.3.2',
                'always' => true,
            ],
            'fontawesome-css' => [
                'rel' => 'stylesheet',
                'type' => 'link',
                'crossorigin' => 'anonymous',
                'integrity' => 'sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==',
                'href' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
                'version' => '6.4.2',
                'always' => true,
            ],
            'vue' => [
                'type' => 'script',
                'crossorigin' => 'anonymous',
                'integrity' => '',
                'src' => 'https://unpkg.com/vue@3',
                'version' => '',
                'always' => true,
            ],
        ],
        'body' => [
            'bootstrap' => [
                'type' => 'script',
                'crossorigin' => 'anonymous',
                'integrity' => 'sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL',
                'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
                'version' => '5.3.2',
                'always' => true,
            ],
            'playground' => [
                'type' => 'script',
                'crossorigin' => 'anonymous',
                'integrity' => '',
                'src' => '/vendor/playground.js',
                'version' => '73.0.0',
                'always' => true,
            ],
            'jquery' => [
                'type' => 'script',
                'crossorigin' => 'anonymous',
                'integrity' => 'sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==',
                'referrerpolicy' => 'no-referrer',
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js',
                'version' => '3.7.1',
                'always' => true,
            ],
            'fontawesome' => [
                'type' => 'script',
                'referrerpolicy' => 'no-referrer',
                'crossorigin' => 'anonymous',
                'integrity' => 'sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==',
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js',
                'version' => '6.4.2',
                'always' => true,
            ],
        ],
    ],
];
