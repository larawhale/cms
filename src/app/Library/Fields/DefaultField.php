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
     * The field constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
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
        return $this->config('label', fn() => $this->key());
    }

    /**
     * Returns a rendered input.
     * 
     * @return string
     */
    public function renderInput(): string
    {
        return FormFacade::input(
            $this->type(),
            $this->key(),
            null,
            ['class' => 'form-control'],
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

        return $entryModel->fields()->updateOrCreate([
            'key' => $this->key(),
        ], compact('value'));
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
}
