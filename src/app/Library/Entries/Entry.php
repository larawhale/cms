<?php

namespace LaraWhale\Cms\Library\Entries;

use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Library\Entries\Contracts\Entry as EntryInterface;

class Entry implements EntryInterface
{
    use HasConfig;

    /**
     * The Entry constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Returns the key of the entry.
     * 
     * @return string
     */
    public function key(): string
    {
        return $this->config('key', null, true);
    }

    /**
     * Returns the name of the entry.
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->config('name', fn() => $this->key());
    }

    /**
     * Returns the fields of the entry.
     * 
     * @return array
     */
    public function fields(): array
    {
        return array_map(
            fn(array $config) => Factory::make($config),
            $this->config('fields', []),
        );
    }

    /**
     * Returns a rendered form.
     * 
     * @return string
     */
    public function renderForm(): string
    {
        return view('cms::entries.form', [
            'entry' => $this,
        ])->render();
    }
}
