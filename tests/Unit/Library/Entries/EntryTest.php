<?php

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Entry;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequriedConfigKeyNotFoundException;

class EntryTest extends TestCase
{
    /**
     * An entry config.
     */
    private array $config = [
        'type' => 'test_key',
        'name' => 'test_name',
        'fields' => [
            [
                'key' => 'test_key',
                'type' => 'test_type',
                'rules' => 'test_rules',
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
        } catch (RequriedConfigKeyNotFoundException $e) {
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
        } catch (RequriedConfigKeyNotFoundException $e) {
            $this->assertEquals('type', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function fields(): void
    {
        $entry = new Entry($this->config);

        $this->assertEquals(
            [new DefaultField($this->config['fields'][0])],
            $entry->fields(),
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
}
