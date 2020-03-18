<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class DefaultField implements Field
{
    use HasConfig;

    /**
     * The Field model instance.
     * 
     * @var \LaraWhale\Cms\Models\Field
     */
    protected $fieldModel;

    /**
     * The field value.
     * 
     * @var array
     */
    protected $value = null;

    /**
     * The field constructor.
     * 
     * @param  array  $config
     * @param  \LaraWhale\Cms\Models\Field
     */
    public function __construct(array $config, FieldModel $fieldModel = null)
    {
        $this->config = $config;

        $this->setFieldModel($fieldModel);
    }

    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function key(): string
    {
        return $this->config('key', null, true);
    }

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function type(): string
    {
        return $this->config('type', null, true);
    }

    /**
     * Returns the rules of the field.
     * 
     * @return string|array
     */
    public function rules()
    {
        return $this->config('rules', []);
    }

    /**
     * Returns the label of the field.
     * 
     * @return string
     */
    public function label(): string
    {
        return __($this->config('label', fn() => $this->key()));
    }

    /**
     * Returns the field model instance.
     * 
     * @return \LaraWhale\Cms\Models\Field|null
     */
    public function fieldModel()
    {
        return $this->fieldModel;
    }

    /**
     * Sets the Field model instance.
     * 
     * @param  \LaraWhale\Cms\Models\Field  $fieldModel
     * @return \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    public function setFieldModel(FieldModel $fieldModel = null): Field
    {
        $this->fieldModel = $fieldModel;

        $this->value = data_get($fieldModel, 'value');

        return $this;
    }

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     * 
     * @param  mixed  $value
     * @return string
     */
    public function databaseValue($value): string
    {
        return (string) $value;
    }

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     * 
     * @return mixed
     */
    public function inputValue()
    {
        return $this->value();
    }

    /**
     * Returns a rendered input.
     * 
     * @return string
     */
    public function renderInput(): string
    {
        $classes = ['form-control'];

        if (optional(request()->session()->get('errors'))->has($this->key())) {
            $classes[] = 'is-invalid';
        }

        return FormFacade::input(
            $this->type(),
            $this->key(),
            $this->inputValue(),
            ['class' => implode(' ', $classes)],
        )->toHtml();
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
            'label' => $this->label(),
            'name' => $this->key(),
        ])->render();
    }

    /**
     * Saves the field to the database.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  mixed  $value
     * @return \LaraWhale\Cms\Models\Field
     */
    public function save(EntryModel $entryModel, $value): FieldModel
    {
        $value = $this->databaseValue($value);

        $fieldModel = $entryModel->fields()->updateOrCreate([
            'key' => $this->key(),
            'type' => $this->type(),
        ], compact('value'));

        $this->setFieldModel($fieldModel);

        return $fieldModel;
    }
}
