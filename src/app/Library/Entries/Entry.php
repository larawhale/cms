<?php

namespace LaraWhale\Cms\Library\Entries;

use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Library\Fields\Factory as FieldFactory;
use LaraWhale\Cms\Library\Entries\Contracts\EntryInterface;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;

class Entry extends BasicEntry implements EntryInterface
{
    use HasConfig;

    /**
     * The type of the entry.
     * 
     * @var string
     */
    protected string $type;

    /**
     * The Entry model instance.
     *
     * @var \LaraWhale\Cms\Models\Entry|null
     */
    protected $entryModel = null;

    /**
     * The CmsEntry constructor.
     *
     * @param  array  $config
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(array $config, EntryModel $entryModel = null)
    {
        $this->config = $config;

        $this->type = $this->config('type', null, true);

        $this->setEntryModel($entryModel);
    }

    /**
     * Returns wether the entry is a single type. Only of a single type may
     * exist.
     *
     * @return bool
     */
    public function isSingle(): bool
    {
        return $this->config('single', false);
    }

    /**
     * Returns the table columns used to render the index page. Columns that
     * are prefixed with `entry_model:` will be retrieved from the entry model.
     *
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->config('table_columns', [
            'entry_model:id',
            'entry_model:type',
            'entry_model:updated_at',
            'entry_model:created_at',
        ]);
    }

    /**
     * Returns the type of the entry.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the name of the entry.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->config('name', fn() => $this->getType());
    }

    /**
     * Returns the view of the entry.
     *
     * @return string
     */
    public function getView(): string
    {
        return $this->config('view', null, true);
    }

    /**
     * Returns the fields of the entry.
     *
     * @return array
     */
    public function getFields(): array
    {
        $fieldModels = data_get(
            $this->getEntryModel(),
            'fields',
            fn() => collect(),
        );

        return array_map(
            function (array $config) use ($fieldModels) {
                $field = FieldFactory::make($config);

                $fieldModel = $fieldModels
                    ->firstWhere('key', $field->getKey());

                $field->setFieldModel($fieldModel);

                return $field;
            },
            $this->config('fields', []),
        );
    }

    /**
     * Returns the rules of the fields.
     *
     * @return array
     */
    public function getRules(): array
    {
        return collect($this->getFields())
            ->mapWithKeys(function (AbstractFieldInterface $field) {
                return $field->getRulesWithKey();
            })
            ->all();
    }

    /**
     * Returns the entry model instance.
     *
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function getEntryModel(): ?EntryModel
    {
        return $this->entryModel;
    }

    /**
     * Set the Entry model instance.
     *
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return self
     */
    public function setEntryModel(?EntryModel $entryModel): self
    {
        $this->entryModel = $entryModel;

        $this->fill($this->entryModel);

        return $this;
    }

    /**
     * Fills the values array according to the specified Entry model.
     *
     * @param  \LaraWhale\Cms\Models\Entry|null  $entryModel
     * @return self
     */
    public function fill(?EntryModel $entryModel): self
    {
        $this->values = [];

        $fieldModels = data_get(
            $entryModel,
            'fields',
            fn() => collect(),
        );

        foreach ($this->getFields() as $field) {
            $fieldModel = $fieldModels->firstWhere('key', $field->getKey());

            $field->setFieldModel($fieldModel);

            $this->values[$field->getKey()] = $field->getValue();
        }

        return $this;
    }

    /**
     * Returns a rendered form.
     *
     * @return string
     */
    public function renderForm(): string
    {
        return view('cms::entries.form', [
            'attributes' => $this->getFormAttributes(),
            'entry' => $this->entryModel ?? new EntryModel([
                'type' => $this->getType(),
            ]),
        ])->render();
    }

    /**
     * Returns the attributes for the form that is being rendered.
     * 
     * @return array
     */
    public function getFormAttributes(): array
    {
        $exists = (bool) optional($this->entryModel)->exists;

        return [
            'files' => true,
            'method' => $exists ? 'patch' : 'post',
            'url' => $exists
                ? route('cms.entries.update', ['entry' => $this->entryModel])
                : route('cms.entries.store'),
        ];
    }

    /**
     * Returns a rendered view.
     *
     * @return string
     */
    public function renderView(): string
    {
        return view($this->getView(), [
            'entry' => $this,
        ])->render();
    }

    /**
     * Saves an entry and its fields to the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  array  $data
     * @return self
     */
    public static function save(EntryModel $entryModel, array $data): self
    {
        dd($data);
        $entryModel->fill($data)->save();

        $entry = $entryModel->toEntryClass();

        $fieldValues = data_get($data, 'fields', []);

        $fieldModels = collect();

        foreach ($entry->getFields() as $field) {
            // Only save the value of the field when it is given in the field
            // values array.
            if (! array_key_exists($field->getKey(), $fieldValues)) {
                continue;
            }

            $fieldModels->push(
                $field->save($entryModel, $fieldValues[$field->getKey()])
                    ->getFieldModel(),
            );
        }

        // Remove the fields that are not in the entry configuration anymore.
        $entryModel->fields()
            ->whereNotIn(
                cms_table_name('fields') . '.id',
                $fieldModels->pluck('id'),
            )
            ->delete();

        // Update updated at timestamp of entry with the latest value of the
        // field models.
        $entryModel->setUpdatedAt($fieldModels->max('updated_at'))->save();

        $entry->setEntryModel($entryModel);

        return $entry;
    }
}
