<?php

namespace LaraWhale\Cms\Exceptions;

use Exception;

class EntryConfigNotFoundException extends Exception
{
    /**
     * The type that was not found.
     *
     * @var string
     */
    protected string $type;

    /**
     * The EntryConfigNotFoundException constructor.
     *
     * @param  string  $type
     */
    public function __construct(string $type)
    {
        parent::__construct(sprintf(
            'An entry configuration could not be found for type "%s"',
            $type,
        ));

        $this->type = $type;
    }

    /**
     * Returns the type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
