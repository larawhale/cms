<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

interface Entry
{
    /**
     * The Entry constructor.
     *
     * @param  array  $values
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(array $values);

    /**
     * Gets the values.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Sets the values.
     *
     * @param  array  $values
     * @return void
     */
    public function setValues(array $values): void;

    /**
     * Gets a value specified by a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue(string $key);

    /**
     * Sets a value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function setValue(string $key, $value): void;
}
