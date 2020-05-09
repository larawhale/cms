<?php

return [

    'entries' => [
        /**
         * The path to the configurations of the entries.
         */
        'path' => resource_path('entries'),
    ],

    'fields' => [
        /**
         * The type and field map.
         *
         * Types that are in this array can be used in the fields entry
         * configuration. New types can be added to this array.
         */
        'classes' => [
            /**
             * The fallback field type for when a type could not be found in
             * this array. This value can of course be overwritten or removed.
             */
            'default' => \LaraWhale\Cms\Library\Fields\InputField::class,

            'checkbox' => \LaraWhale\Cms\Library\Fields\CheckableField::class,
            'entry_select' => \LaraWhale\Cms\Library\Fields\EntrySelectField::class,
            'file' => \LaraWhale\Cms\Library\Fields\FileField::class,
            'input' => \LaraWhale\Cms\Library\Fields\InputField::class,
            'model_select' => \LaraWhale\Cms\Library\Fields\ModelSelectField::class,
            'multi_select' => \LaraWhale\Cms\Library\Fields\MultiSelectField::class,
            'radio' => \LaraWhale\Cms\Library\Fields\CheckableField::class,
            'select' => \LaraWhale\Cms\Library\Fields\SelectField::class,
            'textarea' => \LaraWhale\Cms\Library\Fields\TextAreaField::class,
        ],

        /**
         * The type of field that is used to make entries accessable through
         * requests. The value of this field will be used to create a route.
         */
        'route_field_type' => 'route',
    ],

    'database' => [
        /**
         * A prefix that is used to create table names for tables that are
         * created for this package.
         */
        'table_prefix' => 'cms_',
    ],

    'auth' => [
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
                'model' => \LaraWhale\Cms\Models\User::class,
            ],
        ],
    ],

    'routes' => [
        /**
         * An array of middleware that is added to the cms middleware group and
         * applied to all cms routes.
         */
        'middleware' => [
            'web',
        ],

        /**
         * The middleware used for the cms_auth alias.
         */
        'cms_auth_middleware' => \LaraWhale\Cms\Http\Middleware\Authenticate::class,

        /**
         * The middleware used for the cms_guest alias.
         */
        'cms_guest_middleware' => \LaraWhale\Cms\Http\Middleware\RedirectIfAuthenticated::class,
    ],

];
