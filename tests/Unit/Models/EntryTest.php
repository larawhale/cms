<?php

namespace LaraWhale\Cms\Tests\Unit\Models;

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Contracts\EntryInterface;

class EntryTest extends TestCase
{
    /** @test */
    public function to_entry_class(): void
    {
        $entry = new Entry(['type' => 'test_entry']);

        $this->assertInstanceOf(
            EntryInterface::class,
            $entry->toEntryClass(),
        );
    }
}
