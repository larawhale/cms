<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

interface Entry
{
    /**
     * The Entry constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config);

    /**
     * Returns the config of the entry or the configured value for the
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
     * Returns the key of the entry.
     * 
     * @return string
     */
    public function key(): string;

    /**
     * Returns the name of the entry.
     * 
     * @return string
     */
    public function name(): string;

    /**
     * Returns the fields of the entry.
     * 
     * @return array
     */
    public function fields(): array;

    /**
     * Returns a rendered form.
     * 
     * @return string
     */
    public function renderForm(): string;
}
