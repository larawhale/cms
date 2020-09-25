<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Entry;
use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\InputField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

class EntryTest extends TestCase
{
    /**
     * An entry config.
     */
    private array $config = [
        'type' => 'test_entry',
        'name' => 'Test entry',
        'view' => 'test',
        'fields' => [
            [
                'key' => 'test_key',
                'type' => 'test_type',
                'config' => [
                    'rules' => 'required',
                    'label' => 'test_label',
                ],
            ],
        ],
    ];

    /** @test */
    public function is_single(): void
    {
        $config = array_merge($this->config, ['single' => true]);

        $entry = new Entry($config);

        $this->assertTrue($entry->isSingle());
    }

    /** @test */
    public function is_single_default(): void
    {
        $entry = new Entry($this->config);

        $this->assertFalse($entry->isSingle());
    }

    /** @test */
    public function get_table_columns(): void
    {
        $config = array_merge($this->config, [
            'table_columns' => ['test_key'],
        ]);

        $entry = new Entry($config);

        $this->assertEquals(
            $config['table_columns'],
            $entry->getTableColumns(),
        );
    }

    /** @test */
    public function get_table_columns_default(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals(
            [
                'entry_model:id',
                'entry_model:type',
                'entry_model:updated_at',
                'entry_model:created_at',
            ],
            $entry->getTableColumns(),
        );
    }

    /** @test */
    public function get_name(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals($this->config['name'], $entry->getName());
    }

    /** @test */
    public function get_name_default(): void
    {
        $config = $this->config;

        unset($config['name']);

        $entry = new Entry($config);

        // The default of name is the type.
        $this->assertEquals($this->config['type'], $entry->getName());
    }

    /** @test */
    public function get_view(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals($this->config['view'], $entry->getView());
    }

    /** @test */
    public function get_view_throws_required_config_exception(): void
    {
        $config = $this->config;

        unset($config['view']);

        $entry = new Entry($config);

        try {
            $entry->getView();
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('view', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function get_fields(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $fieldModel = $fieldModel->fresh();

        $fieldConfig = $this->config['fields'][0];

        $fieldClass = new InputField(
            $fieldConfig['key'],
            $fieldConfig['type'],
            $fieldConfig['config'],
            $fieldModel,
        );

        $this->assertEquals(
            [$fieldClass],
            $entry->getFields(),
        );
    }

    /** @test */
    public function get_rules(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $fieldModel = $fieldModel->fresh();

        $this->assertEquals(
            [$fieldModel->key => $this->config['fields'][0]['config']['rules']],
            $entry->getRules(),
        );
    }

    /** @test */
    public function set_entry_model(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config);

        $entry->setEntryModel($fieldModel->entry);

        $this->assertEquals(
            $fieldModel->entry,
            $entry->getEntryModel(),
        );

        // The values should also be set.
        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->getValues(),
        );
    }

    /** @test */
    public function fill(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config);

        $entry->fill($fieldModel->entry);

        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->getValues(),
        );
    }

    /** @test */
    public function fill_null(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->getValues(),
        );

        // Filling the entry with `null` will result in all values to be set to
        // `null`.
        $entry->fill(null);

        $this->assertEquals(
            [$this->config['fields'][0]['key'] => null],
            $entry->getValues(),
        );
    }

    /** @test */
    public function render_form(): void
    {
        $entry = new Entry($this->config);

        $this->assertMatchesHtmlSnapshot($entry->renderForm());
    }

    /** @test */
    public function get_form_attributes(): void
    {
        $entry = new Entry($this->config);

        $this->assertMatchesSnapshot($entry->getFormAttributes());
    }

    /** @test */
    public function get_form_attributes_existing(): void
    {
        $entry = new Entry($this->config, EntryModel::factory()->create());

        $this->assertMatchesSnapshot($entry->getFormAttributes());
    }

    /** @test */
    public function render_view(): void
    {
        $entry = new Entry($this->config);

        $this->assertMatchesHtmlSnapshot($entry->renderView());
    }

    /** @test */
    public function save_create(): void
    {
        $data = [
            'type' => $this->config['type'],
            'fields' => collect($this->config['fields'])
                ->mapWithKeys(
                    fn($field) => [$field['key'] => $field['key'] . '_value'],
                )
                ->all(),
        ];

        Factory::$entries = [
            $this->config['type'] => $this->config,
        ];

        $entryModel = Entry::save(new EntryModel, $data)->getEntryModel();

        $this->assertDatabaseHas('entries', Arr::except($data, ['fields']));

        foreach ($data['fields'] as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entryModel->id,
                'key' => $key,
                'type' => 'test_type',
                'value' => $value,
            ]);
        }
    }

    /** @test */
    public function save_update(): void
    {
        $fieldModel = FieldModel::factory()->create([
            'value' => 'old_value',
        ]);

        $entryModel = $fieldModel->entry;

        // Create another field that is not in the current config of the entry
        // and thus should be deleted.
        FieldModel::factory()->create([
            'entry_id' => $entryModel->id,
            'key' => 'remove_me',
            'type' => 'test_type',
        ]);

        $data = [
            'fields' => [
                $fieldModel->key => 'new_value',
            ],
        ];

        Entry::save($entryModel, $data);

        $this->assertDatabaseHas('fields', [
            'id' => $fieldModel->id,
            'entry_id' => $entryModel->id,
            'key' => $fieldModel->key,
            'type' => $fieldModel->type,
            'value' => 'new_value',
        ]);

        $this->assertDatabaseMissing('fields', [
            'key' => 'remove_me',
        ]);
    }
}
