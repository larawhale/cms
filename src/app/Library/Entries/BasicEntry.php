<?php

namespace LaraWhale\Cms\Library\Entries;

use LaraWhale\Cms\Library\Entries\Contracts\BasicEntryInterface;

class BasicEntry implements BasicEntryInterface
{
    /**
     * An array of values.
     *
     * @var array
     */
    protected array $values = [];

    /**
     * The Entry constructor.
     *
     * @param  array  $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Gets the values.
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Sets the values.
     *
     * @param  array  $values
     * @return self
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Gets a value specified by a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue(string $key)
    {
        return data_get($this->values, $key);
    }

    /**
     * Sets a value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return self
     */
    public function setValue(string $key, $value): self
    {
        data_set($this->values, $key, $value);

        return $this;
    }

    /**
     * Dynamically retrieve values of the entry.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->getValue($key);
    }

    /**
     * Dynamically set values of the entry.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->setValue($key, $value);
    }

    /**
     * Determine if value isset.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return isset($this->values[$key]);
    }

    /**
     * Unset value.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset(string $key): void
    {
        unset($this->values[$key]);
    }
}
