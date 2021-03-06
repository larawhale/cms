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
            $type = $entries->first()->type;

            $browser->loginAs($user)
                ->visit("/cms/entries?type=$type")
                ->screenshot('user_can_index')
                ->assertSee('Test entry entries');
        });
    }

    /** @test */
    public function user_cannot_index_non_existing_type(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Use non existing type.
            ->get('/cms/entries?type=non_existing')
            ->assertStatus(404);
    }
    
    /** @test */
    public function user_cannot_index_no_type(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Do not add type to uri.
            ->get('/cms/entries')
            ->assertStatus(404);
    }

    /** @test */
    public function guest_cannot_index(): void
    {
        // Request without user.
        $this->get('/cms/entries')->assertRedirectLogin();
    }

    /** @test */
    public function single_redirects_to_create(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Use a single entry.
            ->get('/cms/entries?type=single_entry')
            ->assertStatus(302)
            ->assertRedirect('/cms/entries/create?type=single_entry');
    }

    /** @test */
    public function single_redirects_to_edit(): void
    {
        [$user] = $this->prepareTest();

        // Create a single entry.
        $entry = Entry::factory()->create([
            'type' => 'single_entry',
        ]);

        $this->actingAs($user)
            // Use a single entry that exists.
            ->get('/cms/entries?type=single_entry')
            ->assertStatus(302)
            ->assertRedirect("/cms/entries/$entry->id/edit");
    }

    /**
     * Prepares for tests.
     *
     * @return array
     */
    private function prepareTest(): array
    {
        $user = User::factory()->create();

        $entries = Entry::factory()->count(3)->withFields()->create([
            'type' => 'test_entry',
        ]);

        $otherEntries = Entry::factory()->count(3)->withFields()->create([
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
