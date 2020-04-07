# Larawhale CMS

A Laravel package that provides the features of a content management system to any new or existing Laravel application.

## Installation

Add this package to your `composer.json` manually or use the cli.

```
composer require larawhale/cms
```

### Migrations

This package requires a few tables to be present in your database. Run the migration command as soon as you have installed the package.

```
php artisan migrate
```

### Publishing resources

This package has a few resources available to be published to your application.

All resources can be published by using the `cms` tag.

```
php artisan vendor:publish --tag=cms
```

This package also provides separate publishing tags.
- `cms.assets`
  All public asset files needed in the cms views, this includes fonts, css and js.
- `cms.config`
  The configuration file to add custom fields or change the cms user provider for example.
- `cms.views`
  All the views that are rendered in the cms.
- `cms.lang`
  The translations used in the cms views.

### CMS User

A CMS user needs to be available in order to gain access to the CMS. A user can be created by running a command.

```
php artisan cms:create-user
```

## Concepts

This CMS package has been build with a simple concept in mind. There are only two basic entities used: entries and fields. Entries are collectors of fields where fields are entities that contain a single value.

### Entries

An entry is a collector of fields and its values. It will keep track of the values of its fields. The entry has a lot of similarites with the Eloquent model attributes when it comes down to accessing the field values.

### Fields

A field is an entity that contains a single value, think about a simple html input field. It will keep track of the value and other things like validating the value or rendering an input field.

## Authentication

The CMS provides a simple authentication process. Most of it is straight from the `AuthenticatesUsers` trait provided by Laravel.

A user can login by visiting the `GET: /cms/login` endpoint.

Like mentioned before, a user can be created by running the `php artisan cms:create-user` console command where you will be promped with a few questsions.

Publishing the config file, `php artisan vendor:publish --tag=cms.config`, will allow you to configure the guard and/or the provider used to authenticate users.

```php
// config/cms.php
[
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
]

```

## Entries

## Fields
