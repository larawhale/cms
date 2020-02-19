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
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function config($key = null, $default = null);

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
}
