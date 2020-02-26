<?php

namespace LaraWhale\Cms\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model as EloquenModel;

class Model extends EloquenModel
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        $table = parent::getTable();

        // Sometimes the prefix has already been added during relationship
        // initialization.
        if (Str::contains($table, config('cms.table_prefix'))) {
            return $table;
        }

        return cms_table_name($table);
    }
}
