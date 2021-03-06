<?php

if (! function_exists('array_filter_recursive')) {
    /**
     * Filters null attributes inside an array recursively.
     *
     * @param  array  $array
     * @return array
     */
    function array_filter_recursive($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = array_filter_recursive($array[$key]);

                if (empty($array[$key])) {
                    unset($array[$key]);
                }
            }

            if (is_null($value)) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}

if (! function_exists('array_keys_prefix')) {
    /**
     * Add a prefix to array keys.
     *
     * @param  array  $array
     * @param  string  $prefix
     * @return array
     */
    function array_keys_prefix(array $array, string $prefix): array
    {
        $prefixedArray = [];

        foreach ($array as $key => $value) {
            $prefixedArray[$prefix . $key] = $value;
        }

        return $prefixedArray;
    }
}

if (! function_exists('cms_entries_path')) {
    /**
     * Returns the path where the entries or the specified entry configuration
     * is located.
     *
     * @param  string  $type
     * @return string
     */
    function cms_entries_path(string $type = ''): string
    {
        return config('cms.entries.path')
            . ($type ? DIRECTORY_SEPARATOR . "$type.php" : $type);
    }
}

if (! function_exists('cms_table_name')) {
    /**
     * Returns string with the cms table prefix.
     *
     * @param  string  $tableName
     * @return string
     */
    function cms_table_name(string $tableName): string
    {
        return sprintf(
            '%s%s',
            config('cms.database.table_prefix'),
            $tableName
        );
    }
}

if (! function_exists('is_current_route')) {
    /**
     * Validates if the given route is the current route.
     *
     * @param  string  $routeName
     * @param  array  $parameters
     * @return bool
     */
    function is_current_route(string $routeName, array $parameters = []): bool
    {
        return request()->fullUrlIs(route($routeName, $parameters));
    }
}
