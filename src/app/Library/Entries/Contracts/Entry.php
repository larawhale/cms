<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

use LaraWhale\Cms\Models\Entry as EntryModel;

interface Entry
{
    /**
     * The Entry constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config);

    /**
     * Returns the config of the entry or the configured value for the
     * specified key.
     * 
     * @param  string  $key
     * @param  mixed  $default
     * @param  bool  $throw
     * @return mixed
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public function config(string $key = null, $default = null, bool $throw = false);

    /**
     * Returns the type of the entry.
     * 
     * @return string
     */
    public function type(): string;

    /**
     * Returns the name of the entry.
     * 
     * @return string
     */
    public function name(): string;

    /**
     * Returns the fields of the entry.
     * 
     * @return array
     */
    public function fields(): array;

    /**
     * Returns the entry model instance.
     * 
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function entryModel();

    /**
     * Set the Entry model instance.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public function setEntryModel(EntryModel $entryModel = null): Entry;

    /**
     * Returns field the values.
     * 
     * @return array
     */
    public function values(): array;

    /**
     * Fills the values array according to the specified Entry model.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public function fill(EntryModel $entryModel = null): Entry;

    /**
     * Returns a rendered form.
     * 
     * @return string
     */
    public function renderForm(): string;

    /**
     * Saves an entry and its fields to the database.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  array  $data
     * @return \LaraWhale\Cms\Models\Entry
     */
    public static function save(EntryModel $entryModel, array $data): EntryModel;
}
