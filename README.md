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

This package has been built with a simple concept in mind. There are only two basic entities used: entries and fields. Entries are entities that contain multiple values, where fields contain a single value. An entry makes use of fields to fill its values.

### Entries

An entry can be seen as a class with properties. However in this case the properties and its values are determined by the configured fields instead of predefined properties.

### Fields

A field is an entitiy that can be seen as a single value. It will also keep track of its type, validation and more.

## Authentication

The package provides a simple authentication process straight from Laravel itself.

A user can login by visiting the `GET: /cms/login` endpoint.

Like mentioned before, a user can be created by running the `php artisan cms:create-user` console command where you will be prompted with a few questsions.

Publishing the config file, `php artisan vendor:publish --tag=cms.config`, will allow you to configure the guard and the provider used to authenticate users.

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
