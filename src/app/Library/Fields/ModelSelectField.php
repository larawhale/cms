<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Support\Collection;

class ModelSelectField extends SelectField
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
                return [
                    $model->getKey() => data_get($model, $labelKey),
                ];
            })
            ->all();
    }

    /**
     * Returns the label key of the list item.
     *
     * @return string|array|int
     */
    public function getListItemLabelkey()
    {
        return $this->config('list_item_label_key', 'id');
    }

    /**
     * Returns the configured model class.
     *
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->config('model_class', null, true);
    }

    /**
     * Retrieves the models from the database that should be in the list.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModelList(): Collection
    {
        return $this->getModelListQuery()->get();
    }

    /**
     * Prepares a query that should retrieve the models.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModelListQuery()
    {
        $modelClass = $this->getModelClass();

        $query = $modelClass::query();

        $constraint = $this->getQueryConstraint();

        $constraint($query);

        return $query;
    }

    /**
     * Returns the configured query constraint.
     *
     * @return callable
     */
    public function getQueryConstraint(): callable
    {
        return $this->config('query_constraint', fn() => function () {
        });
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

        return $modelClass::find($this->value);
    }
}
