<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | The default locale that will be used if no locale is specified in
    | the request header or if the specified locale is not supported.
    |
    */
    'default_locale' => env('APP_DEFAULT_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | List of locales that your application supports. These will be used
    | for locale validation in the LocalizationMiddleware.
    |
    */
    'supported_locales' => explode(',', env('APP_SUPPORTED_LOCALES', 'en,ru')),

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale to use when the current one is not available.
    |
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
];