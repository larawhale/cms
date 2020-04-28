<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Library\Fields\Contracts\BasicFieldInterface;

class BasicField implements BasicFieldInterface
{
    /**
     * The key of the field.
     * 
     * @var string
     */
    protected string $key;

    /**
     * The type of the field.
     * 
     * @var string
     */
    protected string $type;

    /**
     * The value of the field.
     * 
     * @var mixed
     */
    protected $value = null;

    /**
     * The Field constructor.
     * 
     * @param  string  $key
     * @param  string  $type
     * @param  mixed  $value
     */
    public function __construct(string $key, string $type, $value = null)
    {
        $this->key = $key;

        $this->type = $type;

        $this->value = $value;
    }

    /**
     * Returns the key of the field.
     * 
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns the type of the field.
     * 
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the value of the field.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of the field
     * 
     * @param  mixed  $value
     * @return self
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }
}
