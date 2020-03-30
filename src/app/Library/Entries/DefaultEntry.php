<?php

namespace LaraWhale\Cms\Library\Entries;

use Carbon\Carbon;
use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Library\Config\HasConfig;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\Contracts\Field as FieldInterface;
use LaraWhale\Cms\Library\Entries\Contracts\Entry as EntryInterface;

class DefaultEntry implements EntryInterface
{
    use HasConfig;

    /**
     * The Entry model instance.
     *
     * @var \LaraWhale\Cms\Models\Entry
     */
    protected $entryModel;

    /**
     * An array of field values.
     *
     * @var array
     */
    protected $values = [];

    /**
     * The Entry constructor.
     *
     * @param  array  $config
     * @param  \LaraWhale\Cms\Models\Entry
     */
    public function __construct(array $config, EntryModel $entryModel = null)
    {
        $this->config = $config;

        $this->setEntryModel($entryModel);
    }

    /**
     * Returns wether the entry is a single type. Only of a single type may
     * exist.
     *
     * @return bool
     */
    public function single(): bool
    {
        return $this->config('single', false);
    }

    /**
     * Returns the table columns used to render the index page. Columns that
     * are prefixed with `entry_model:` will be retrieved from the entry model.
     *
     * @return array
     */
    public function tableColumns(): array
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
    public function type(): string
    {
        return $this->config('type', null, true);
    }

    /**
     * Returns the name of the entry.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->config('name', fn() => $this->type());
    }

    /**
     * Returns the view of the entry.
     *
     * @return string
     */
    public function view(): string
    {
        return $this->config('view', null, true);
    }

    /**
     * Returns the fields of the entry.
     *
     * @return array
     */
    public function fields(): array
    {
        $fieldModels = data_get(
            $this->entryModel,
            'fields',
            fn() => collect(),
        );

        return array_map(
            function (array $config) use ($fieldModels) {
                $field = Factory::make($config);

                $fieldModel = $fieldModels
                    ->firstWhere('key', $field->key());

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
    public function rules(): array
    {
        return collect($this->fields())
            ->mapWithKeys(function (FieldInterface $field) {
                return [$field->key() => $field->rules()];
            })
            ->all();
    }

    /**
     * Returns the entry model instance.
     *
     * @return \LaraWhale\Cms\Models\Entry|null
     */
    public function entryModel()
    {
        return $this->entryModel;
    }

    /**
     * Set the Entry model instance.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public function setEntryModel(EntryModel $entryModel = null): EntryInterface
    {
        $this->entryModel = $entryModel;

        $this->fill($this->entryModel);

        return $this;
    }

    /**
     * Returns field the values.
     *
     * @return array
     */
    public function values(): array
    {
        return $this->values;
    }

    /**
     * Returns a value.
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
     * @return void
     */
    public function setValue(string $key, $value): void
    {
        data_set($this->values, $key, $value);
    }

    /**
     * Fills the values array according to the specified Entry model.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @return \LaraWhale\Cms\Library\Entries\Contracts\Entry
     */
    public function fill(EntryModel $entryModel = null): EntryInterface
    {
        $this->values = [];

        $fieldModels = data_get(
            $entryModel,
            'fields',
            fn() => collect(),
        );

        foreach ($this->fields() as $field) {
            $fieldModel = $fieldModels->firstWhere('key', $field->key());

            $this->values[$field->key()] = data_get($fieldModel, 'value');
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
                'type' => $this->type(),
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
        return view($this->view(), [
            'entry' => $this,
        ])->render();
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

        foreach ($entry->fields() as $field) {
            // Only save the value of the field when it is given in the field
            // values array.
            if (! array_key_exists($field->key(), $fieldValues)) {
                continue;
            }

            $fieldModels->push(
                $field->save($entryModel, $fieldValues[$field->key()]),
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
