<?php

namespace LaraWhale\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;
use Illuminate\Database\Eloquent\Factories\Factory as DatabaseFactory;

class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'key', 'type', 'value',
    ];

    /**
     * The entry relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Scope a query to only include records that have a certain type.
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
     * Get the instance as an Field class.
     *
     * @return \LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface
     */
    public function toFieldClass(): AbstractFieldInterface
    {
        return Factory::make(
            [
                'key' => $this->key,
                'type' => $this->type,
            ],
            $this,
        );
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(): DatabaseFactory
    {
        return FieldFactory::new();
    }
}
