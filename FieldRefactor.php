<?php

require __DIR__ . '/vendor/autoload.php';

use Collective\Html\FormFacade;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

interface FieldInterface
{
    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function getKey(): string;

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function getType(): string;

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue();

    /**
     * Sets the value of the field
     * 
     * @param  mixed  $value
     * @return self
     */
    public function setValue($value): self;
}

class Field implements FieldInterface
{
    /**
     * The key of the field.
     * 
     * @var string
     */
    protected string $key;

    /**
     * The type of the field.
     * 
     * @var string
     */
    protected string $type;

    /**
     * The value of the field.
     * 
     * @var mixed
     */
    protected $value = null;

    /**
     * The Field constructor.
     * 
     * @param  string  $key
     * @param  string  $type
     * @param  mixed  $value
     */
    public function __construct(string $key, string $type, $value = null)
    {
        $this->key = $key;

        $this->type = $type;

        $this->value = $value;
    }

    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of the field
     * 
     * @param  mixed  $value
     * @return self
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }
}

interface CmsFieldInterface extends FieldInterface
{
    /**
     * Returns the config of the field or the configured value for the
     * specified key.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @param  bool  $throw
     * @return mixed
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public function config(string $key = null, $default = null, bool $throw = false);

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDatabaseValue($value): string;

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     *
     * @return mixed
     */
    public function getInputValue();

    /**
     * Returns the configured rules of the field.
     *
     * @return string|array
     */
    public function getRules();

    /**
     * Returns the configured label of the field.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Returns the FieldModel instance of the field.
     *
     * @return \LaraWhale\Cms\Models\Field|null
     */
    public function getFieldModel();

    /**
     * Sets the FieldModel instance of the field.
     *
     * @param  \LaraWhale\Cms\Models\Field|null  $fieldModel
     * @return \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    public function setFieldModel(?FieldModel $fieldModel): self;

    /**
     * Returns a rendered input.
     *
     * @return mixed
     */
    public function renderInput();

    /**
     * Returns a rendered form group.
     *
     * @return string
     */
    public function renderFormGroup(): string;

    /**
     * Saves the field to the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  mixed  $value
     * @return self
     */
    public function save(EntryModel $entryModel, $value): self;
}

abstract class CmsField extends Field implements CmsFieldInterface
{
    use HasConfig;

    /**
     * The Field model instance.
     *
     * @var \LaraWhale\Cms\Models\Field
     */
    protected $fieldModel = null;

    /**
     * The Field constructor.
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
     * Returns the FieldModel instance of the field.
     *
     * @return \LaraWhale\Cms\Models\Field|null
     */
    public function getFieldModel(): ?FieldModel
    {
        return $this->fieldModel;
    }

    /**
     * Sets the FieldModel instance of the field.
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
            'type' => $this->getType(),
        ], compact('value'));

        $this->setFieldModel($fieldModel);

        return $this;
    }
}

class InputField extends CmsField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return FormFacade::input(
            $this->getType(),
            $this->getKey(),
            $this->getInputValue(),
            [
                'class' => $this->getInputClass(),
                'id' => $this->getKey(),
            ],
        )->toHtml();
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return string
     */
    public function getInputClass(): string
    {
        $classes = ['form-control'];

        if (request()->hasSession()
            && optional(request()->session()->get('errors'))->has($this->key())
        ) {
            $classes[] = 'is-invalid';
        }

        return implode(' ', $classes);
    }
}


$field = new InputField([
    'key' => 'test_key',
    'type' => 'test_type',
]);

var_dump($field->getFieldModel());

echo PHP_EOL;
