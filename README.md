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

