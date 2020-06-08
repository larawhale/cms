<?php

namespace LaraWhale\Cms\Library\Fields\Concerns;

trait HasArrayValue
{
    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return is_array($this->value)
            ? $this->value
            : json_decode($this->value, true) ?? [];
    }

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDatabaseValue($value): string
    {
        return is_null($value)
            ? ''
            : (is_string($value)
                ? $value
                : json_encode($value));
    }

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     *
     * @return mixed
     */
    public function getInputValue()
    {
        return is_array($this->value)
            ? $this->value
            : json_decode($this->value, true) ?? [];
    }
}
