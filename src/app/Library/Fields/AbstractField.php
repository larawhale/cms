<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;

abstract class AbstractField extends BasicField implements AbstractFieldInterface
{
    use HasConfig;

    /**
     * The Field model instance.
     *
     * @var \LaraWhale\Cms\Models\Field
     */
    protected $fieldModel = null;

    /**
     * The AbstractField constructor.
     * 
     * @param  array  $config
     * @param  \LaraWhale\Cms\Models\Field
     */
    public function __construct(array $config, FieldModel $fieldModel = null)
    {
        $this->config = $config;

        $this->key = $this->config('key', null, true);

        $this->type = $this->config('type', null, true);

        $this->setFieldModel($fieldModel);
    }

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDatabaseValue($value): string
    {
        return (string) $value;
    }

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     *
     * @return mixed
     */
    public function getInputValue()
    {
        return $this->getValue();
    }

    /**
     * Returns the configured rules of the field.
     *
     * @return string|array
     */
    public function getRules()
    {
        return $this->config('rules', []);
    }

    /**
     * Returns the configured label of the field.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return __($this->config('label', fn() => $this->getKey()));
    }

    /**
     * Returns the Field model instance of the field.
     *
     * @return \LaraWhale\Cms\Models\Field|null
     */
    public function getFieldModel(): ?FieldModel
    {
        return $this->fieldModel;
    }

    /**
     * Sets the Field model instance of the field.
     *
     * @param  \LaraWhale\Cms\Models\Field|null  $fieldModel
     * @return \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    public function setFieldModel(?FieldModel $fieldModel): self
    {
        $this->fieldModel = $fieldModel;

        $this->value = data_get($fieldModel, 'value');

        return $this;
    }

    /**
     * Returns a rendered form group.
     *
     * @return string
     */
    public function renderFormGroup(): string
    {
        return view('cms::components.form.group', [
            'input' => $this->renderInput(),
            'label' => $this->getLabel(),
            'name' => $this->getKey(),
        ])->render();
    }

    /**
     * Saves the field to the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  mixed  $value
     * @return self
     */
    public function save(EntryModel $entryModel, $value): self
    {
        $value = $this->getDatabaseValue($value);

        $fieldModel = $entryModel->fields()->updateOrCreate([
            'key' => $this->getKey(),
        ], [
            'type' => $this->getType(),
            'value' => $value,
        ]);

        $this->setFieldModel($fieldModel);

        return $this;
    }
}