<?php

namespace LaraWhale\Cms\Library\Entries;

use Illuminate\Support\Facades\File;
use LaraWhale\Cms\Library\Entries\Entry;
use LaraWhale\Cms\Exceptions\EntryConfigNotFoundException;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;
use LaraWhale\Cms\Library\Entries\Contracts\Entry as EntryInterface;

class Factory
{
    /**
     * The type and entry map.
     * 
     * @var array
     */
    public static array $entries = [];

    /**
     * Makes an instance of entry according to the given type.
     * 
     * @param  string  $type
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public static function make(string $type): Entry
    {
        $config = static::resolve($type);

        return new Entry($config);
    }

    /**
     * Resolves the type to an entry config.
     * 
     * @param  strin  $type
     * @return array
     * @throws \LaraWhale\Cms\Exceptions\EntryConfigNotFoundException
     */
    public static function resolve(string $type): array
    {
        $config = data_get(static::$entries, $type);

        if (is_null($config)) {
            throw new EntryConfigNotFoundException($type);
        }

        return $config;
    }

    /**
     * Retreives all the entry configurations.
     * 
     * @return void
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public static function loadEntries(): void
    {
        $files = File::allFiles(cms_entries_path());;

        foreach ($files as $file) {
            $config = require $file->getPathname();

            $type = data_get($config, 'type');

            if (is_null($type)) {
                throw new RequiredConfigKeyNotFoundException($config, 'type');
            }

            static::$entries[$type] = $config;
        }
    }
}
