<?php

return [

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

];
