# Larawhale CMS

A Laravel package that provides the features of a content management system to any new or existing Laravel application.

The package uses a simple concept of two entities, entries and fields. Entries can be seen as models, where fields are the properties of these models. This concept allows for simple and quick ajustments to the data that is shown to the users.

The goal of this package is to take the management of user input out of the hands of the developer while maintaining as much customizability as possible. Additionally it is important to impact the developers process as little as possible.

## Requirements

- `"php": "^7.4"`
- `"laravel/framework": "^6.15"`

## Getting started

The following will help you install and start using the package.

### Installation

This package can be installed using composer:

```
composer require larawhale/cms
```

After installation you should run the migrations:

```
php artisan migrate
```

Last but not least you should publish the resources by using the `cms` tag:

```
php artisan vendor:publish --tag=cms
```

This package also provides separate publishing tags to prevent you application from cluttering with files you do not need.

  - `cms.assets` **(required)**<br>
    All public asset files required for the user interface, this includes fonts, css and javascript.
  - `cms.config`<br>
    The configuration file to add custom fields, change the user provider and more.
  - `cms.entries`<br>
    One or more pre made entry configurations.
  - `cms.views`<br>
    All the views that are rendered as the user interface.
  - `cms.lang`<br>
    The translations used in the user interface.

### Creating a user

A user needs to be present in the database in order to gain access to the user interface. A user can be created by running a command:

```
php artisan cms:create-user
```

This command will prompt for a few answers before the user will be created.

The user may now login at `/cms/login` after it has been created.

### Entry configuration

Entries are simply configured using php files located in the default `resources/entries` folder. An example entry configuration might look like:

```php
return [
    'type' => 'first_entry',
    'name' => 'My first entry',
    'view' => 'entries.first_entry',
    'fields' => [
        [
            'key' => 'url',
            'type' => 'route',
            'rules' => 'required',
            'label' => 'Url',
        ],
        [
            'key' => 'title',
            'type' => 'text',
            'rules' => 'required',
            'label' => 'Title',
        ],
        [
            'key' => 'body',
            'type' => 'textarea',
            'rules' => 'required',
            'label' => 'Body',
        ],
    ],
];
```

More information about entry and field configuration can be found in the **...** section.

## The concept

The package uses a simple concept of two entities, entries and fields.

### Entries

Entries are just like models. They are objects that contain properties with values. The developer will control which properties are available by configuration. Properties are configured by adding fields to the entry.

### Fields

Fields can be seen as the properties of an entry. Fields keep track of the value, how they are validated, how the input field should be rendered in the user interface and much more.

## Entries

The models of the CMS.

### Configuration

The configuration of your entries live in the default `resources/entries` folder. However you are free the configure a different path by changing the `cms.entries.path` configuration.

| Property | Type | Description |
|-----------------|---------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `type` | string | **required** An identifier that helps the package to indentify what type of entry it is handeling. The value can be anything as long as it is unique to other entry types, it does not have to be the same as the filename. |
| `name` | string | The name of an entry will be used in the user interface to let the users identify what they are viewing, creating, editing or deleting. By default it will use the `type` value. |
| `single` | boolean | A boolean that indicates if there should only exist one of this entry type. |
| `table_columns` | array | An array of field keys that are used to render the table on the overview page. By default it will display the `id`, `type`, `updated_at` and `created_at`. Prefix a field key with `entry_model:` to retrieve the value from the entry model rather than from a field, eg: `enry_model:id`. |
| `view` | string | A reference to a blade file that is used to render when a user visits the url on which the entry is made available. This property is only required when the entry has a so called **@@`route_field_type`@@**. |
| `fields` | array | An array of **@@field configurations@@** that should be made available to the entry as well as rendered in forms of the user interface. |

## Fields

The properties of the entries.

### Configuration

| Property | Description |
|-----------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `key` | **required** An identifier that helps the package to indentify what type of entry it is handeling. The value can be anything as long as it is unique to other entry types, it does not have to be the same as the filename. |
| `type` | The name of an entry will be used in the user interface to let the users identify what they are viewing, creating, editing or deleting. By default it will use the `type` value. |
| `single` | A boolean that indicates if there should only exist one of this entry type. |
| `table_columns` | An array of field keys that are used to render the table on the overview page. By default it will display the `id`, `type`, `updated_at` and `created_at`. Prefix a field key with `entry_model:` to retrieve the value from the entry model rather than from a field, eg: `enry_model:id`. |
| `view` | A reference to a blade file that is used to render when a user visits the url on which the entry is made available. This property is only required when the entry has a so called **@@`route_field_type`@@**. |
| `fields` | An array of **@@field configurations@@** that should be made available to the entry as well as rendered in forms of the user interface. |
