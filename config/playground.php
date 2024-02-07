<?php

return [
    'user' => env('PLAYGROUND_USER', 'App\\Models\\User'),
    'user_id' => env('PLAYGROUND_USER_ID', 'increments'),
    'user_table' => env('PLAYGROUND_USER_TABLE', 'users'),
    'layout' => env('PLAYGROUND_LAYOUT', 'playground::layouts.site'),
    'packages' => array_map('trim', explode(',', env('PLAYGROUND_PACKAGES', 'playground'))),
    'view' => env('PLAYGROUND_VIEW', 'playground::'),
    'auth' => [
        /**
         * Privileges checks in this order:
         * - Sanctum: HasApiTokens
         * - method_exists: hasPrivilege
         *
         * @var string $verify roles|privileges
         */
        'verify' => env('PLAYGROUND_AUTH_VERIFY', 'privileges'),
        // 'verify' => env('PLAYGROUND_AUTH_VERIFY', 'roles'),
        'token' => [
            'name' => 'app',
        ],
        'sanctum' => (bool) env('PLAYGROUND_AUTH_SANCTUM', false),
        'hasPrivilege' => (bool) env('PLAYGROUND_AUTH_HAS_PRIVILEGE', false),
        'userPrivileges' => (bool) env('PLAYGROUND_AUTH_USER_PRIVILEGES', false),
        'hasRole' => (bool) env('PLAYGROUND_AUTH_HAS_ROLE', false),
        'userRole' => (bool) env('PLAYGROUND_AUTH_USER_ROLE', false),
        'userRoles' => (bool) env('PLAYGROUND_AUTH_USER_ROLES', false),
    ],
    'date' => [
        'sql' => env('PLAYGROUND_DATE_MYSQL', 'Y-m-d H:i:s'),
    ],
    'load' => [
        'routes' => (bool) env('PLAYGROUND_LOAD_ROUTES', false),
        'views' => (bool) env('PLAYGROUND_LOAD_VIEWS', false),
    ],
    'purifier' => [
        'iframes' => env(
            'PLAYGROUND_PURIFIER_IFRAMES',
            '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%'
        ),
        'path' => env('PLAYGROUND_PURIFIER_PATH', ''),
    ],
];
