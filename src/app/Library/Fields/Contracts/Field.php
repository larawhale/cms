<?php

namespace LaraWhale\Cms\Library\Fields\Contracts;

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
     * @throws \LaraWhale\Cms\Exceptions\RequriedConfigKeyNotFoundException
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
}
