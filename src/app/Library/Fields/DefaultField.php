<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Library\Fields\Contracts\Field;
use LaraWhale\Cms\Exceptions\RequriedFieldConfigKeyNotFoundException;

class DefaultField implements Field
{
    /**
     * The config of the field.
     * 
     * @var array
     */
    protected array $config;

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
     * Returns the config of the field or the configured value for the
     * specified key.
     * 
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        return data_get($this->config, $key, $default);
    }

    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function key(): string
    {
        if (! array_key_exists('key', $this->config)) {
            throw new RequriedFieldConfigKeyNotFoundException($this, 'key');
        }

        return $this->config['key'];
    }

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function type(): string
    {
        if (! array_key_exists('type', $this->config)) {
            throw new RequriedFieldConfigKeyNotFoundException($this, 'type');
        }

        return $this->config['type'];
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
}
