<?php

return [

    /**
     * The path to the configurations of the entries.
     */
    'entries_path' => resource_path('entries'),

    /**
     * The type and field map.
     * 
     * Types that are in this array can be used in the fields entry
     * configuration. New types can be added to this array.
     */
    'fields' => [
        /**
         * The fallback field type for when a type could not be found in this
         * array. This value can of course be overwritten or removed.
         */
        'default' => \LaraWhale\Cms\Library\Fields\DefaultField::class,
    ],

    /**
     * A prefix that is used to create table names for tables that are created
     * for this package.
     */
    'table_prefix' => 'cms_',

    /**
     * The active authentication guard used to protect cms routes.
     */
    'guard' => 'cms',

    /**
     * The authentication guard configurations.
     */
    'guards' => [
        'cms' => [
            'driver' => 'session',
            'provider' => 'cms',
        ],
    ],

    /**
     * The authentication provider configurations.
     */
    'providers' => [
        'cms' => [
            'driver' => 'eloquent',
            'provider' => \LaraWhale\Cms\Models\User::class,
        ],
    ],

    /**
     * An array of middleware that is added to the cms middleware group.
     */
    'middleware' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

];
