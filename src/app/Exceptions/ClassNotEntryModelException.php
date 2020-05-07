<?php

namespace LaraWhale\Cms\Exceptions;

use Exception;
use LaraWhale\Cms\Models\Entry as EntryModel;

class ClassNotEntryModelException extends Exception
{
    /**
     * The class that was not the entry model class.
     *
     * @var string
     */
    protected string $class;

    /**
     * The ClassNotEntryModelException constructor.
     *
     * @param  string  $class
     */
    public function __construct(string $class)
    {
        parent::__construct(sprintf(
            'The model class should be equal or extend from %s. %s given instead.',
            EntrModel::class,
            $class,
        ));

        $this->class = $class;
    }

    /**
     * Returns the class.
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
