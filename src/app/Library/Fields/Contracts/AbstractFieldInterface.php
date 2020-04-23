<?php

namespace LaraWhale\Cms\Library\Fields\Contracts;

use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;

interface AbstractFieldInterface extends BasicFieldInterface
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
