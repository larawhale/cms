<?php

namespace LaraWhale\Cms\Models;

use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Library\Entries\Contracts\Entry as EntryInterface;

class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    /**
     * Get the instance as an Entry class.
     *
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public function toEntryClass(): EntryInterface
    {
        return Factory::make($this->type);
    }
}
