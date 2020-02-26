<?php

// Add namespace to prevent "Cannot declare class" fatal error because of
// ..\Fields\FactoryTest.
namespace LaraWhale\Cms\Tests\Unit\Library\Entries;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Library\Entries\Contracts\Entry;
use LaraWhale\Cms\Exceptions\EntryConfigNotFoundException;
use LaraWhale\Cms\Exceptions\RequriedConfigKeyNotFoundException;

class FactoryTest extends TestCase
{
    /**
     * The entries that are loaded.
     * 
     * @var array
     */
    private array $entries = [
        'test_entry' => [
            'type' => 'test_entry',
            'name' => 'Test entry',
            'fields' => [
                [
                    'key' => 'test_key',
                    'type' => 'test_type',
                    'rules' => 'test_rules',
                    'label' => 'test_label',
                ],
            ],
        ],
    ];

    /** @test */
    public function make(): void
    {
        Factory::$entries = $this->entries;

        $this->assertInstanceOf(
            Entry::class,
            Factory::make('test_entry'),
        );
    }

    /** @test */
    public function resolve_throws_entry_config_not_found(): void
    {
        try {
            Factory::make('unknown_entry');
        } catch (EntryConfigNotFoundException $e) {
            $this->assertEquals('unknown_entry', $e->getType());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }
}
