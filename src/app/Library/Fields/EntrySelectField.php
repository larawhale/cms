<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Support\Collection;
use LaraWhale\Cms\Models\Entry as EntryModel;

class EntrySelectField extends ModelSelectField
{
    /**
     * Returns the configured model class.
     * 
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->config('model_class', EntryModel::class);
    }
}
