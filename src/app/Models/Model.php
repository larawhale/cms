<?php

namespace LaraWhale\Cms\Models;

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
        return cms_table_name(parent::getTable());
    }
}
