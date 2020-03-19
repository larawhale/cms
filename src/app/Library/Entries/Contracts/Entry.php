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
     * Returns wether the entry is a single type. Only of a single type may
     * exist.
     * 
     * @return bool
     */
    public function single(): bool;

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
     * Returns the view of the entry.
     * 
     * @return string
     */
    public function view(): string;

    /**
     * Returns the fields of the entry.
     * 
     * @return array
     */
    public function fields(): array;

    /**
     * Returns the rules of the fields.
     * 
     * @return array
     */
    public function rules(): array;

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
     * Returns a value.
     * 
     * @param  string  $key
     * @return mixed
     */
    public function getValue(string $key);

    /**
     * Sets a value.
     * 
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function setValue(string $key, $value): void;

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
     * Returns a rendered view.
     * 
     * @return string
     */
    public function renderView(): string;

    /**
     * Saves an entry and its fields to the database.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  array  $data
     * @return \LaraWhale\Cms\Models\Entry
     */
    public static function save(EntryModel $entryModel, array $data): EntryModel;
}
