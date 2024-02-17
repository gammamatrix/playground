<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Packages
    |--------------------------------------------------------------------------
    |
    | The array of packages from PLAYGROUND_PACKAGES will be listed in the
    | Playground section in artisan:about.
    |
    | - These packages will have their respective sitemaps loaded, if applicable.
    |
    | NOTE: PLAYGROUND_AUTH_PACKAGES may also be defined to load abilities.
    |
    */

    'packages' => is_string(env('PLAYGROUND_PACKAGES', 'playground')) ? array_map(
        'trim',
        explode(',', env('PLAYGROUND_PACKAGES', 'playground'))
    ) : [],

    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    |
    | PLAYGROUND_DATE_SQL is used to format dates for SQL handling. Where possible
    | Illuminate\Support\Carbon is use to handle dates, including formatting.
    */

    'date' => [
        'sql' => env('PLAYGROUND_DATE_SQL', 'Y-m-d H:i:s'),
    ],
];
