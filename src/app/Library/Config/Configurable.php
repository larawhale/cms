<?php

namespace LaraWhale\Cms\Library\Config;

interface Configurable
{
    /**
     * Returns the config of the class or the configured value for the
     * specified key.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @param  bool  $throw
     * @return mixed
     */
    public function config(string $key = null, $default = null, bool $throw = false);
}
