<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Support\Collection;
use LaraWhale\Cms\Models\Entry as EntryModel;

class EntrySelectField extends ModelSelectField
{
    /**
     * Returns a list of models used to display in the select.
     * 
     * @return array
     */
    public function getList(): array
    {
        $labelKey = $this->getListItemLabelkey();

        return $this->getModelList()
            ->mapWithKeys(function ($model) use ($labelKey) {
                $entry = $model->toEntryClass();

                return [
                    $model->getKey() => data_get($entry, $labelKey),
                ];
            })
            ->all();
    }

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
