# Larawhale CMS

A Laravel package that provides the features of a content management system to any new or existing Laravel application.

The package uses a simple concept of two entities, entries and fields. Entries can be seen as models, where fields are the properties of these models. This concept allows for simple and quick ajustments to the data that is shown to the users.

The goal of this package is to take the management of user input out of the hands of the developer while maintaining as much customizability as possible. Additionally it is important to impact the developers process as low as possible.

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

  - `cms.assets` (required)<br>
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

### Entrie

Entries are just like models. They are objects that contain properties with values. The developer will control which properties are available by configuration. Properties are configured by adding fields to the entry.

### Fields

Fields can be seen as the properties of an entry. Fields keep track of the value, how they are validated, how the input field should be rendered in the user interface and much more.

## Entries

The models of the CMS.

### Configuration

The configuration of your entries live in the default `resources/entries` folder. However you are free the configure a different path by changing the `cms.entries.path` configuration.

| Property | Description |
|-----------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `type` | **required** An identifier that helps the package to indentify what type of entry it is handeling. The value can be anything as long as it is unique to other entry types, it does not have to be the same as the filename. |
| `name` | The name of an entry will be used in the user interface to let the users identify what they are viewing, creating, editing or deleting. By default it will use the `type` value. |
| `single` | A boolean that indicates if there should only exist one of this entry type. |
| `table_columns` | An array of field keys that are used to render the table on the overview page. By default it will display the `id`, `type`, `updated_at` and `created_at`. Prefix a field key with `entry_model:` to retrieve the value from the entry model rather than from a field, eg: `enry_model:id`. |
| `view` | A reference to a blade file that is used to render when a user visits the url on which the entry is made available. This property is only required when the entry has a so called **@@`route_field_type`@@**. |
| `fields` | An array of **@@field configurations@@** that should be made available to the entry as well as rendered in forms of the user interface. |

## Fields

The values of the entries.

### Configuration




Entries a

If this is your first time, lets dissect this configuration together. A more in depth documentation about confiration of entries can be found in the **...** section.

`type` (required)
This is a property that helps the package identify what type of entry it is handeling. The value is something you as the developer controls, it can be anything as long as it can be stored as text in the database.

`name`
The name of an entry will be used in the user interface to let the users identify what they are viewing, creating, editing or deleting.

`view`
The view is a reference to a blade file that might be used to render when a user visits the url on which the entry is available. Not all entries are required to have a `view` configured, more can be read about this in the **...** section.

`fields`
And array of field configurations that belong to the type of entry. This array contains all the fields that should be displayed in the user interface forms and made available in your configured `view` blade file.

Each field configuration is structured in a similar way, but with different properties.

`key` (required)
The value if this property is used as an identifier and should be unique within the same type of entry. This means you can have the same value for `key` in different type of entries. The value of this property will also be used as the accessor on the entry in your blade view. In this case that could be `$entry->title`, but more about this in the **...** section.

`type` (required)
The type property is an indicator for the package which type of field it is handeling. According to the value it might render a different input field or store the value in a different way. By default this value will be used as the `type` value attribute of an `input` element. However it is also possible to create your own custom types, more about this in the **...** section.

`rules`
The value of the rules will be used to validate the input the user has given during creating or updating an entry. The rules are written exactly the same way as you are used to in a Laravel application. This means you could use custom rules, closures or other [validation features](https://laravel.com/docs/master/validation) Laravel supplies.

`label`
This property will be used to display to the user, it is the label of the field. The package will try to translate this value, so a value like `inputs.title.label` might be translated.
