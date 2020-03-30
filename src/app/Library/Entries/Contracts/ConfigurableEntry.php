<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

use LaraWhale\Cms\Library\Config\Configurable;

interface ConfigurableEntry extends BaseEntry, Configurable
{
    /**
     * The Entry constructor.
     *
     * @param  array  $config
     * @param  array  $values
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(array $config, array $values);
}
