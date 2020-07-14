<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Entries;

use PHPUnit\Framework\TestCase;
use LaraWhale\Cms\Library\Entries\BasicEntry;
use LaraWhale\Cms\Library\Entries\Contracts\BasicEntryInterface;

class BasicEntryTest extends TestCase
{
    /**
     * The BasicEntry instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Entries\Contracts\BasicEntryInterface
     */
    private BasicEntry $entry;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->entry = new BasicEntry(['test_key' => 'test_value']);
    }

    /** @test */
    public function get_values(): void
    {
        $this->assertEquals(
            ['test_key' => 'test_value'],
            $this->entry->getValues(),
        );
    }

    /** @test */
    public function set_values(): void
    {
        $this->entry->setValues(['key_test' => 'value_test']);

        $this->assertEquals(
            ['key_test' => 'value_test'],
            $this->entry->getValues(),
        );
    }

    /** @test */
    public function get_value(): void
    {
        $this->assertEquals(
            'test_value',
            $this->entry->getValue('test_key'),
        );
    }

    /** @test */
    public function set_value(): void
    {
        $this->entry->setValue('test_key', 'value_test');

        $this->assertEquals(
            'value_test',
            $this->entry->getValue('test_key'),
        );
    }

    /** @test */
    public function get(): void
    {
        $this->assertEquals(
            'test_value',
            $this->entry->test_key,
        );
    }

    /** @test */
    public function set(): void
    {
        $this->entry->test_key = 'value_test';

        $this->assertEquals(
            'value_test',
            $this->entry->test_key,
        );
    }

    /** @test */
    public function isset(): void
    {
        $this->assertTrue(isset($this->entry->test_key));

        $this->assertFalse(isset($this->entry->key_test));
    }

    /** @test */
    public function unset(): void
    {
        unset($this->entry->test_key);

        $this->assertNull($this->entry->test_key);
    }
}
