<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

use LaraWhale\Cms\Models\Entry as EntryModel;

interface EntryInterface extends BasicEntryInterface
{
    /**
     * Returns the config of the field or the configured value for the
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
    public function isSingle(): bool;

    /**
     * Returns the table columns used to render the index page. Columns that
     * are prefixed with `entry_model:` will be retrieved from the entry model.
     *
     * @return array
     */
    public function getTableColumns(): array;

    /**
     * Returns the type of the entry.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Returns the name of the entry.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the view of the entry.
     *
     * @return string
     */
    public function getView(): string;

    /**
     * Returns the fields of the entry.
     *
     * @return array
     */
    public function getFields(): array;

    /**
     * Returns the rules of the fields.
     *
     * @return array
     */
    public function getRules(): array;

    /**
     * Returns the entry model instance.
     *
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function getEntryModel(): ?EntryModel;

    /**
     * Set the Entry model instance.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return self
     */
    public function setEntryModel(?EntryModel $entryModel): self;

    /**
     * Fills the values array according to the specified Entry model.
     *
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return self
     */
    public function fill(?EntryModel $entryModel): self;

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
}
