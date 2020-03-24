<?php

namespace LaraWhale\Cms\Models;

use LaraWhale\Cms\Models\Entry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

class EntryCollection extends Collection
{
    /**
     * Get the item instances as an Entry class.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toEntryClass(): BaseCollection
    {
        return $this->map(fn(Entry $entry) => $entry->toEntryClass());
    }
}
