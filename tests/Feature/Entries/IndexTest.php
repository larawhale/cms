<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\Entry;
use Illuminate\Support\Facades\DB;
use LaraWhale\Cms\Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    /** @test */
    public function admin_can_index(): void
    {
        [$entries] = $this->prepareEntries();

        $this->browse(function ($browser) use ($entries) {
            $browser->visit('/cms/entries')
                ->screenshot('admin_can_index');
        });

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function admin_can_index_type(): void
    {
        [$entries] = $this->prepareEntries();

        $this->browse(function ($browser) use ($entries) {
            $type = $entries->first()->type;

            $browser->visit("/cms/entries?type=$type")
                ->screenshot('admin_can_index_type');
        });

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_index(): void
    {
        $response = $this->get('/cms/entries');

        $this->markTestIncomplete('No authentication assertion');

        $response->assertStatus(403);
    }

    /**
     * Prepares entries for tests.
     * 
     * @return array
     */
    private function prepareEntries(): array
    {
        $entries = factory(Entry::class, 3)->states('with_fields')->create([
            'type' => 'test_entry',
        ]);

        $otherEntries = factory(Entry::class, 3)->states('with_fields')->create([
            'type' => 'another_test_entry',
        ]);

        // Update updated at and created at to be a consistent date to prevent
        // changes to the screenshots to be made.
        DB::table(cms_table_name('entries'))->update([
            'updated_at' => '1970-01-02 03:04:05',
            'created_at' => '1970-01-02 03:04:05',
        ]);

        return [$entries->merge($otherEntries)];
    }
}
