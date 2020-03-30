<?php

namespace LaraWhale\Cms\Library\Entries\Contracts;

use Illuminate\Support\Collection;
use LaraWhale\Cms\Models\Entry as EntryModel;

interface ModelEntry extends Entry
{
    /**
     * The ModelEntry constructor.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(EntryModel $entryModel = null);

    /**
     * Gets the entry model instance.
     *
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function getEntryModel();

    /**
     * Sets the entry model instance.
     *
     * @param \LaraWhale\Cms\Models\Entry|null
     * @return void
     */
    public function setEntryModel(EntryModel $entryModel = null): void;

    /**
     * Gets the field model instances from the entry model.
     * 
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return \Illuminate\Support\Collection
     */
    public function getFieldModels(EntryModel $entryModel = null): Collection;

    /**
     * Gets the field instances from the field models that are related to the
     * entry model.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getFields(): Collection;

    /**
     * Fills the values array according to the specified entry model.
     *
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return void
     */
    public function fill(EntryModel $entryModel = null): void;
}
