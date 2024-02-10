<?php

return [
    'user' => env('PLAYGROUND_USER', 'App\\Models\\User'),
    'user_id' => env('PLAYGROUND_USER_ID', 'uuid'),
    'user_table' => env('PLAYGROUND_USER_TABLE', 'users'),
    'packages' => is_string(env('PLAYGROUND_PACKAGES', 'playground')) ? array_map('trim', explode(',', env('PLAYGROUND_PACKAGES', 'playground'))) : [],
    // 'auth' => [
    //     /**
    //      * Privileges checks in this order:
    //      * - Sanctum: HasApiTokens
    //      * - method_exists: hasPrivilege
    //      *
    //      * @var string $verify roles|privileges
    //      */
    //     'verify' => env('PLAYGROUND_AUTH_VERIFY', 'privileges'),
    //     // 'verify' => env('PLAYGROUND_AUTH_VERIFY', 'roles'),
    //     'token' => [
    //         'name' => 'app',
    //     ],
    //     'sanctum' => (bool) env('PLAYGROUND_AUTH_SANCTUM', false),
    //     'hasPrivilege' => (bool) env('PLAYGROUND_AUTH_HAS_PRIVILEGE', false),
    //     'userPrivileges' => (bool) env('PLAYGROUND_AUTH_USER_PRIVILEGES', false),
    //     'hasRole' => (bool) env('PLAYGROUND_AUTH_HAS_ROLE', false),
    //     'userRole' => (bool) env('PLAYGROUND_AUTH_USER_ROLE', false),
    //     'userRoles' => (bool) env('PLAYGROUND_AUTH_USER_ROLES', false),
    // ],
    'date' => [
        'sql' => env('PLAYGROUND_DATE_SQL', 'Y-m-d H:i:s'),
    ],
    'purifier' => [
        'iframes' => env(
            'PLAYGROUND_PURIFIER_IFRAMES',
            '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%'
        ),
        'path' => env('PLAYGROUND_PURIFIER_PATH', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Settings for Testing
    |--------------------------------------------------------------------------
    |
    */

    'testing' => [
        'password' => env('PLAYGROUND_TESTING_PASSWORD'),
        'hashed' => (bool) env('PLAYGROUND_TESTING_HASHED', false),
    ],

];
