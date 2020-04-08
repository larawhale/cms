# Larawhale CMS

A Laravel package that provides the features of a content management system to any new or existing Laravel application.

## Getting started

The following will help you install and use the package for the first time.

### Installation

This package can be installed using composer:

```
composer require larawhale/cms
```

After installation you should run the migrations:

```
php artisan migrate
```

Further more you should publish the resources by using the `cms` tag:

```
php artisan vendor:publish --tag=cms
```

This package also provides separate publishing tags:

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

A user needs to be present in the databse in order to gain access to the user interface. A user can be created by running a command:

```
php artisan cms:create-user
```

This command will prompt for a few answers before the user will be created.

The user may now login at `/cms/login` after it has been created.

### Entry configuration

An entry needs to be configured for your users to be able to view anyhting in their browsers

The configuration files of the entries live in the `resouces/entries` folder. One configuration file will already be present when you published all the resources or with the `cms.entries` tag. Do not worry when you do not see the folder, just create the `resources/entries` folder and put an empty `first_entry.php` file in there.

Your first entry configuration might look like this:

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


## Entry configuration



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
