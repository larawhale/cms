<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use Illuminate\Support\Facades\DB;
use LaraWhale\Cms\Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    /** @test */
    public function user_can_index(): void
    {
        [$user, $entries] = $this->prepareTest();

        $this->browse(function ($browser) use ($user, $entries) {
            $browser->loginAs($user)
                ->visit('/cms/entries')
                ->screenshot('user_can_index');
        });
    }

    /** @test */
    public function user_can_index_type(): void
    {
        [$user, $entries] = $this->prepareTest();

        $this->browse(function ($browser) use ($user, $entries) {
            $type = $entries->first()->type;

            $browser->loginAs($user)
                // Request with type.
                ->visit("/cms/entries?type=$type")
                ->screenshot('user_can_index_type');
        });
    }

    /** @test */
    public function guest_cannot_index(): void
    {
        // Request without user.
        $this->get('/cms/entries')->assertRedirectToLogin();
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    private function prepareTest(): array
    {
        $user = factory(User::class)->create();

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

        return [$user, $entries->merge($otherEntries)];
    }
}
