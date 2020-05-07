<?php

namespace LaraWhale\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use LaraWhale\Cms\Library\Entries\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaraWhale\Cms\Library\Entries\Contracts\EntryInterface;

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
     * The fields relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Scope a query to only include entries of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Create a new Entry Collection instance.
     *
     * @param  array  $models
     * @return \LaraWhale\Cms\Models\EntryCollection
     */
    public function newCollection(array $models = []): EntryCollection
    {
        return new EntryCollection($models);
    }

    /**
     * Get the instance as an Entry class.
     *
     * @return \LaraWhale\Cms\Library\Entries\Contracts\EntryInterface
     */
    public function toEntryClass(): EntryInterface
    {
        return Factory::make($this->type, $this);
    }
}
