<?php

namespace LaraWhale\Cms\Exceptions;

use Exception;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class RequriedFieldConfigKeyNotFoundException extends Exception
{
    /**
     * The field where the key was not found.
     * 
     * @var \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    protected Field $field;

    /**
     * The key was not found.
     * 
     * @var string
     */
    protected string $key;

    /**
     * The RequriedFieldConfigKeyNotFoundException constructor.
     * 
     * @param  \LaraWhale\Cms\Library\Fields\Contracts\Field  $field
     * @param  string  $key
     */
    public function __construct(Field $field, string $key)
    {
        parent::__construct(sprintf(
            'A required field config key was not found for "%s" using "%s"',
            get_class($field),
            $key,
        ));

        $this->field = $field;

        $this->key = $key;
    }

    /**
     * Returns the field.
     * 
     * @return \LaraWhale\Cms\Library\Fields\Contracts\Field
     */
    public function getField(): Field
    {
        return $this->field;
    }

    /**
     * Returns the key.
     * 
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
