# Larawhale CMS - A Laravel CMS package

A Laravel package that provides the features of a content management system to any new or existing Laravel application.

This package uses a simple concept of two entities, entries and fields. Entries can be seen as models, where fields are the properties of these models.

The goal of this package is to take the implementation of managing content out of the hands of the developer while maintaining as much customizability as possible. It is important to keep the development process the same as how developers are used to while using the Laravel framework.

## Installation

This package can be installed using composer:

```
composer require larawhale/cms
```

**NOTE!** <br />
At the moment the `larawhale` namespace is already in use on Packagist, the owner has been contacted to add this package. For now the package can be added as repository to the `composer.json`. More information can be found in the [composer documentation](https://getcomposer.org/doc/05-repositories.md#vcs).

Read more about the installation of this package in the [documentation](https://github.com/larawhale/cms/wiki/Installation).

## Example

Here is a quick example how an entry can be configured. The entry will be made available in the user interface when it is saved in the default `resources/entries` folder.

```php
// resources/entries/post.php
return [
    'type' => 'post',
    'name' => 'Post',
    'view' => 'entries.post',
    'fields' => [
        [
            'key' => 'route',
            'type' => 'route',
            'config' => [
                'rules' => 'required',
                'label' => 'Url',
            ],
        ],
        [
            'key' => 'title',
            'type' => 'text',
            'config' => [
                'rules' => 'required|string|max:191',
                'label' => 'Title',
            ],
        ],
        [
            'key' => 'body',
            'type' => 'textarea',
            'config' => [
                'rules' => 'required|string|max:1000',
                'label' => 'Body',
            ],
        ],
    ],
];
```
More information can be found at the [entries configuration](https://github.com/larawhale/cms/wiki/Entry-configuration) and [fields configutation](https://github.com/larawhale/cms/wiki/Field-configuration) documentation.

This configuration will result in the following form to be rendered in the user interface.

![Rendered post entry form](https://user-images.githubusercontent.com/8861831/83181950-e2411780-a125-11ea-8660-27a7b7fe8930.png)

The configured fields of this entry have now been made available in the configured `resources/views/entries/post.blade.php` file.

```html
// resources/views/entries/post.blade.php
<h1>
    {{ $entry->title }}
</h1>

{!! $entry->body !!}
```



## Documentation

The documentation is available on the [repository wiki](https://github.com/larawhale/cms/wiki/Introduction).

## License

This package falls under the MIT License (MIT). See the [license file](https://github.com/larawhale/cms/blob/master/LICENSE) for more information.
