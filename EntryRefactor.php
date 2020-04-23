<?php

require __DIR__ . '/vendor/autoload.php';

use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Concerns\HasConfig;

interface BasicEntryInterface
{
    /**
     * Gets the values.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Sets the values.
     *
     * @param  array  $values
     * @return self
     */
    public function setValues(array $values): self;

    /**
     * Gets a value specified by a key.
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
     * @return self
     */
    public function setValue(string $key, $value): self;
}

class BasicEntry implements BasicEntryInterface
{
    /**
     * An array of values.
     *
     * @var array
     */
    protected array $values = [];

    /**
     * The Entry constructor.
     *
     * @param  array  $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Gets the values.
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Sets the values.
     *
     * @param  array  $values
     * @return self
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Gets a value specified by a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue(string $key)
    {
        return data_get($this->values, $key);
    }

    /**
     * Sets a value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return self
     */
    public function setValue(string $key, $value): self
    {
        data_set($this->values, $key, $value);

        return $this;
    }

    /**
     * Dynamically retrieve values of the entry.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->getValue($key);
    }

    /**
     * Dynamically set values of the entry.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->setValue($key, $value);
    }

    /**
     * Determine if value isset.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return isset($this->values[$key]);
    }

    /**
     * Unset value.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset(string $key): void
    {
        unset($this->values[$key]);
    }
}

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
    public function setEntryModel(EntryModel $entryModel = null): self;

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
     * @var \LaraWhale\Cms\Models\Entry
     */
    protected $entryModel;

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
                $field = Factory::make($config);

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
            ->mapWithKeys(function (FieldInterface $field) {
                return [$field->getKey() => $field->getRules()];
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
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return self
     */
    public function setEntryModel(EntryModel $entryModel = null): self
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

            $this->values[$field->getKey()] = data_get($fieldModel, 'value');
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
            'entry' => $this->entryModel ?? new EntryModel([
                'type' => $this->getType(),
            ]),
        ])->render();
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
     * @return \LaraWhale\Cms\Models\Entry
     */
    public static function save(EntryModel $entryModel, array $data): EntryModel
    {
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
                $field->save($entryModel, $fieldValues[$field->getKey()]),
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

        return $entryModel;
    }
}

$entry = new Entry([
    'type' => 'test',
]);

dd($entry->getValues());
