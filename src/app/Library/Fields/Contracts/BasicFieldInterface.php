<?php

namespace LaraWhale\Cms\Library\Fields\Contracts;

interface BasicFieldInterface
{
    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function getKey(): string;

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function getType(): string;

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue();

    /**
     * Sets the value of the field
     * 
     * @param  mixed  $value
     * @return self
     */
    public function setValue($value): self;
}
