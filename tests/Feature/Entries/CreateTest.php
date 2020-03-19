<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    /** @test */
    public function user_can_create(): void
    {
        [$user] = $this->prepareTest();

        $data = $this->requestData();

        $this->browse(function ($browser) use ($user, $data) {
            $url = '/cms/entries/create?type=' . $data['type'];

            $browser->loginAs($user)
                ->visit($url)
                ->screenshot('user_can_create')
                ->type('input[name=test_key]', $data['test_key'])
                ->type('input[name=another_test_key]', $data['another_test_key'])
                ->click('@submit-entry')
                ->assertPathIs('/cms/entries');
        });

        $this->assertDatabase($data);
    }

    /** @test */
    public function guest_cannot_create(): void
    {
        $data = $this->requestData();

        $url = '/cms/entries/create?type=' . $data['type'];

        // Request without user.
        $response = $this->get($url);

        $response->assertRedirectLogin();
    }

    /** @test */
    public function cannot_create_non_existing_type(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Use non existing type.
            ->get('/cms/entries/create?type=non_existing')
            ->assertStatus(404);
    }

    /** @test */
    public function cannot_create_no_type(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Do not add type to uri.
            ->get('/cms/entries/create')
            ->assertStatus(404);
    }

    /** @test */
    public function single_create(): void
    {
        [$user] = $this->prepareTest();

        $this->actingAs($user)
            // Use a single entry.
            ->get('/cms/entries/create?type=single_entry')
            ->assertStatus(200);
    }

    /** @test */
    public function single_redirects_to_edit(): void
    {
        [$user] = $this->prepareTest();

        // Create a single entry.
        $entry = factory(Entry::class)->create([
            'type' => 'single_entry',
        ]);

        $this->actingAs($user)
            // Use a single entry that exists.
            ->get('/cms/entries/create?type=single_entry')
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
        $user = factory(User::class)->create();

        return [$user];
    }

    /**
     * Returns data used in requests.
     * 
     * @return array
     */
    private function requestData(): array
    {
        return [
            'type' => 'test_entry',
            'test_key' => 'test_key_value',
            'another_test_key' => 'another_stest_key_value',
        ];
    }

    /**
     * Asserts the database.
     *
     * @param  string  $data
     * @return void
     */
    private function assertDatabase(array $data): void
    {
        $entry = Entry::where('type', $data['type'])->firstOrFail();

        $fields = Arr::except($data, ['type']);

        foreach ($fields as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entry->id,
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
