<?php

if (! function_exists('cms_table_name')) {
    /**
     * Returns string with the cms table prefix.
     * 
     * @param  string  $tableName
     * @return bool
     */
    function cms_table_name(string $tableName): string
    {
        return sprintf(
            '%s%s',
            config('cms.table_prefix'),
            $tableName
        );
    }
}

if (! function_exists('cms_entries_path')) {
    /**
     * Returns string with the cms table prefix.
     * 
     * @param  string  $type
     * @return bool
     */
    function cms_entries_path(string $type = ''): string
    {
        return config('cms.entries_path')
            . ($type ? DIRECTORY_SEPARATOR . "$type.php" : $type);
    }
}
