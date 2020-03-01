<?php

namespace LaraWhale\Cms\Tests\Library\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Entry;
use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

class EntryTest extends TestCase
{
    /**
     * An entry config.
     */
    private array $config = [
        'type' => 'test_type',
        'name' => 'test_name',
        'fields' => [
            [
                'key' => 'test_key',
                'type' => 'test_type',
                'rules' => 'required',
                'label' => 'test_label',
            ],
        ],
    ];

    /** @test */
    public function type(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals($this->config['type'], $entry->type());
    }

    /** @test */
    public function key_throws_required_config_exception(): void
    {
        $entry = new Entry([]);

        try {
            $entry->type();
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('type', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function name(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals($this->config['name'], $entry->name());
    }

    /** @test */
    public function name_uses_type(): void
    {
        $entry = new Entry(['type' => $this->config['type']]);

        $this->assertEquals($this->config['type'], $entry->name());
    }

    /** @test */
    public function name_throws_required_config_exception(): void
    {
        $entry = new Entry([]);

        try {
            $entry->name();
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('type', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function fields(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $fieldModel = $fieldModel->fresh();

        $this->assertEquals(
            [new DefaultField($this->config['fields'][0], $fieldModel)],
            $entry->fields(),
        );
    }

    /** @test */
    public function rules(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $fieldModel = $fieldModel->fresh();

        $this->assertEquals(
            [$fieldModel->key => $this->config['fields'][0]['rules']],
            $entry->rules(),
        );
    }

    /** @test */
    public function set_entry_model(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config);

        $entry->setEntryModel($fieldModel->entry);

        $this->assertEquals(
            $fieldModel->entry,
            $entry->entryModel(),
        );

        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->values(),
        );
    }

    /** @test */
    public function get_value_existing(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $this->assertEquals(
            $fieldModel->value,
            $entry->getValue($fieldModel->key),
        );
    }

    /** @test */
    public function get_value_unknown(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals(
            null,
            $entry->getValue('unknown'),
        );
    }

    /** @test */
    public function set_value(): void
    {
        $entry = new Entry($this->config);

        $entry->setValue('test_key', 'test_value');

        $this->assertEquals(
            'test_value',
            $entry->getValue('test_key'),
        );
    }

    /** @test */
    public function fill(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config);

        $entry->fill($fieldModel->entry);

        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->values(),
        );
    }

    /** @test */
    public function fill_resets(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $this->assertEquals(
            [$fieldModel->key => $fieldModel->value],
            $entry->values(),
        );

        $entry->fill(null);

        $this->assertEquals(
            [$this->config['fields'][0]['key'] => null],
            $entry->values(),
        );
    }

    /** @test */
    public function render_form(): void
    {
        $config = $this->config;

        $config['fields'][] = [
            'key' => 'another_test_key',
            'type' => 'another_test_type',
            'rules' => 'another_test_rules',
            'label' => 'another_test_label',
        ];

        $entry = new Entry($config);

        $this->assertMatchesHtmlSnapshot($entry->renderForm());
    }

    /** @test */
    public function magic_get_existing(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $this->assertEquals(
            $fieldModel->value,
            $entry->{$fieldModel->key},
        );
    }

    /** @test */
    public function magic_get_unknown(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals(
            null,
            $entry->unknown,
        );
    }

    /** @test */
    public function magic_set(): void
    {
        $entry = new Entry($this->config);

        $entry->test_key = 'test_value';

        $this->assertEquals(
            'test_value',
            $entry->test_key,
        );
    }

    /** @test */
    public function magic_isset_existing(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        $this->assertTrue(
            isset($entry->{$fieldModel->key}),
        );
    }

    /** @test */
    public function magic_isset_unknown(): void
    {
        $entry = new Entry($this->config);

        $this->assertFalse(
            isset($entry->unknown),
        );
    }

    /** @test */
    public function magic_unset(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['fields'][0]['key'],
        ]);

        $entry = new Entry($this->config, $fieldModel->entry);

        unset($entry->{$fieldModel->key});

        $this->assertFalse(
            isset($entry->unknown),
        );
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

        $entryModel = Entry::save(new EntryModel, $data);

        $this->assertDatabaseHas('entries', Arr::except($data, ['fields']));

        foreach ($data['fields'] as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entryModel->id,
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    /** @test */
    public function save_update(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'value' => 'old_value',
        ]);

        $entryModel = $fieldModel->entry;

        // Create another field that is not in the current config of the entry
        // and thus should be deleted.
        $shouldDelete = factory(FieldModel::class)->create([
            'entry_id' => $entryModel->id,
            'key' => 'remove_me',
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
            'value' => 'new_value',
        ]);

        $this->assertDatabaseMissing('fields', [
            'id' => $shouldDelete->id,
        ]);
    }
}
