<?php

namespace LaraWhale\Cms\Library\Entries;

use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Entries\Contracts\ModelEntry as EntryInterface;

class ModelEntry extends Entry implements ModelEntryInterface
{
    /**
     * The entry model instance.
     * 
     * @var \LaraWhale\Cms\Models\Entry
     */
    protected EntryModel $entryModel;

    /**
     * The EntryModel constructor.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(EntryModel $entryModel = null)
    {
        // TODO: Test if a relation can be queried on a non existing model.
        // This way this class will always have a entry model instance intead
        // of having to check this.
        $this->setEntryModel($entryModel);
    }

    /**
     * Gets the entry model instance.
     *
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function getEntryModel()
    {
        return $this->entryModel;
    }

    /**
     * Sets the entry model instance.
     *
     * @param \LaraWhale\Cms\Models\Entry|null
     * @return void
     */
    public function setEntryModel(EntryModel $entryModel = null): void
    {
        $this->entryModel = $entryModel;

        $this->fill($this->entryModel);
    }

    /**
     * Gets the field model instances from the entry model.
     * 
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return \Illuminate\Support\Collection
     */
    public function getFieldModels(EntryModel $entryModel = null): Collection
    {
        return data_get(
            $entryModel ?? $this->entryModel,
            'fields',
            fn() => collect(),
        );
    }

    /**
     * Gets the field instances from the field models that are related to the
     * entry model.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getFields(): Collection
    {
        return $this->getFieldModels()
            ->map(function (FieldModel $fieldModel) {
                // TODO: Implement this method.
                return $field->toFieldClass();
            });
    }


    /**
     * Fills the values array according to the specified entry model.
     *
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return void
     */
    public function fill(EntryModel $entryModel = null): void
    {
        // TODO: This loop can be done on the entry model itself.
        $values = [];

        foreach ($this->getFieldModels($entryModel) as $field) {
            $values[$field->key] = $field->value;
        }

        $this->setValues($values);
    }
}
