<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Pagination
    |--------------------------------------------------------------------------
    */
    'pagination' => [
        'default_per_page' => env('API_DEFAULT_PER_PAGE', 15),
        'max_per_page' => env('API_MAX_PER_PAGE', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Response Format
    |--------------------------------------------------------------------------
    */
    'response' => [
        'include_locale' => env('API_INCLUDE_LOCALE', true),
        'include_timestamp' => env('API_INCLUDE_TIMESTAMP', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    | Uses Laravel's built-in rate limiting features
    */
    'rate_limiting' => [
        'enabled' => env('API_RATE_LIMITING_ENABLED', true),
        'limits' => [
            'auth' => env('API_AUTH_RATE_LIMIT', 10),
            'api' => env('API_GLOBAL_RATE_LIMIT', 60),
            'users' => env('API_USERS_RATE_LIMIT', 30),
        ],
    ],
];