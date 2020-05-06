<?php

namespace LaraWhale\Cms\Library\Fields;

use Exception;
use Illuminate\Support\Collection;
use LaraWhale\Cms\Models\Entry as EntryModel;

class EntrySelectField extends ModelSelectField
{
    /**
     * Returns the configured entry type that is used to contraint the query to
     * only return entries of a certain type.
     * 
     * @return string
     */
    public function getEntryType(): string
    {
        return $this->config('entry_type', null);
    }

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
        $modelClass = $this->config('model_class', EntryModel::class);

        // The model class should be the Entry model class or extend from it.
        // This field expects some functionality to be present when it queries
        // or creates instances with the class.
        if ($modelClass !== EntryModel::class
            && ! is_subclass_of($modelClass, EntryModel::class)
        ) {
            $message = sprintf(
                'The model class should be equal or extend from %s. %s given instead.',
                EntryModel::class,
                $modelClass,
            );

            throw new Exception($message);
        }

        return $modelClass;
    }

    /**
     * Prepares a query that should retrieve the models.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModelListQuery()
    {
        $query = parent::getModelListQuery();

        if (! is_null($type = $this->getEntryType())) {
            $query->type($type);
        }

        return $query;
    }

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue()
    {
        if (is_null($this->value)) {
            return $this->value;
        }

        $modelClass = $this->getModelClass();

        return optional($modelClass::find($this->value))->toEntryClass();
    }
}
