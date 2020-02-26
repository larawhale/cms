<?php

namespace LaraWhale\Cms\Library\Concerns;

use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

trait HasConfig
{
    /**
     * The config of the class.
     * 
     * @var array
     */
    protected array $config;

    /**
     * Returns the config of the class or the configured value for the
     * specified key.
     * 
     * @param  string  $key
     * @param  mixed  $default
     * @param  bool  $throw
     * @return mixed
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public function config(string $key = null, $default = null, bool $throw = false)
    {
        if (is_null($key)) {
            return $this->config;
        }

        if ($throw && ! array_key_exists($key, $this->config)) {
            throw new RequiredConfigKeyNotFoundException($this, $key);
        }

        return data_get($this->config, $key, $default);
    }
}
