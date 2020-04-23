<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

interface BasicEntryInterface
{
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
     * @return self
     */
    public function setValues(array $values): self;

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
     * @return self
     */
    public function setValue(string $key, $value): self;
}
