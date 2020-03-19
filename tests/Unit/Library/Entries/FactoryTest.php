<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Entries;

use Mockery\Mock;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Library\Entries\Contracts\Entry;
use LaraWhale\Cms\Exceptions\EntryConfigNotFoundException;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

class FactoryTest extends TestCase
{
    /** @test */
    public function make(): void
    {
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

    /** @test */
    public function exists_true(): void
    {
        $this->assertTrue(Factory::exists('test_entry'));
    }

    /** @test */
    public function exists_false(): void
    {
        $this->assertFalse(Factory::exists('non_existing'));
    }

    /** @test */
    public function entries(): void
    {
        foreach (Factory::entries() as $entry) {
            $this->assertInstanceOf(Entry::class, $entry);
        }

        $this->assertCount(
            count(Factory::$entries),
            Factory::entries(),
        );
    }
}
