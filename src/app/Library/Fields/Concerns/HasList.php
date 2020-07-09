<?php

namespace LaraWhale\Cms\Library\Fields\Concerns;

trait HasList
{
    /**
     * Returns the configured list.
     * 
     * @return array
     */
    public function getList(): array
    {
        return $this->config('list', []);
    }
}
