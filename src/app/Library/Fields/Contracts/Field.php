<?php

namespace LaraWhale\Cms\Library\Fields\Contracts;

use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;

interface Field
{
    /**
     * The field constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config);

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
     * Returns the key of the field.
     * 
     * @return string
     */
    public function key(): string;

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function type(): string;

    /**
     * Returns the rules of the field.
     * 
     * @return string|array
     */
    public function rules();

    /**
     * Returns the label of the field.
     * 
     * @return string
     */
    public function label(): string;

    /**
     * Returns the field model instance.
     * 
     * @return \LaraWhale\Cms\Models\Field|null
     */
    public function fieldModel();

    /**
     * Sets the Field model instance.
     * 
     * @param  \LaraWhale\Cms\Models\Field  $fieldModel
     * @return \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    public function setFieldModel(FieldModel $fieldModel = null): Field;

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function value();

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     * 
     * @param  mixed  $value
     * @return string
     */
    public function databaseValue($value): string;

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     * 
     * @return mixed
     */
    public function inputValue();

    /**
     * Returns a rendered input.
     * 
     * @return string
     */
    public function renderInput(): string;

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
     * @return \LaraWhale\Cms\Models\Field
     */
    public function save(EntryModel $entryModel, $value): FieldModel;
}
