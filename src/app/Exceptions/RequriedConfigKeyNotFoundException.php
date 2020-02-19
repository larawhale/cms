<?php

namespace LaraWhale\Cms\Exceptions;

use Exception;
class RequriedConfigKeyNotFoundException extends Exception
{
    /**
     * The class where the key was not found.
     * 
     * @var mixed
     */
    protected $class;

    /**
     * The key was not found.
     * 
     * @var string
     */
    protected string $key;

    /**
     * The RequriedConfigKeyNotFoundException constructor.
     * 
     * @param  mixed  $class
     * @param  string  $key
     */
    public function __construct($class, string $key)
    {
        parent::__construct(sprintf(
            'A required config key was not found for "%s" using "%s"',
            get_class($class),
            $key,
        ));

        $this->class = $class;

        $this->key = $key;
    }

    /**
     * Returns the class.
     * 
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
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
