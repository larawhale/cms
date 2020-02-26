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

];
