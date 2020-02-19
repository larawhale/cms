<?php

namespace LaraWhale\Cms\Exceptions;

use Exception;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class RequriedFieldConfigKeyNotFoundException extends Exception
{
    /**
     * The RequriedFieldConfigKeyNotFoundException constructor.
     * 
     * @param  LaraWhale\Cms\Library\Fields\Contracts\Field  $field
     * @param  string  $key
     */
    public function __construct(Field $field, string $key)
    {
        parent::__construct(sprintf(
            'A required field config key was not found for "%s" using "%s"',
            get_class($field),
            $key,
        ));
    }
}
