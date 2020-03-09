<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    /** @test */
    public function admin_can_create(): void
    {
        [$user] = $this->prepare();

        $data = $this->requestData();

        $this->browse(function ($browser) use ($data) {
            $url = '/cms/entries/create?type=' . $data['type'];

            $browser->visit($url)
                ->screenshot('admin_can_create')
                ->type('input[name=test_key]', $data['test_key'])
                ->type('input[name=another_test_key]', $data['another_test_key'])
                ->click('@submit-entry');
        });

        $this->assertDatabase($data);

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_create(): void
    {
        $data = $this->requestData();

        $url = '/cms/entries/create?type=' . $data['type'];

        $response = $this->get($url);

        $this->markTestIncomplete('No authentication assertion');

        $response->assertStatus(403);
    }

    /** @test */
    public function cannot_create_non_type(): void
    {
        $this->get('/cms/entries/create')->assertStatus(404);
    }

    /**
     * Prepares for tests.
     * 
     * @return \LaraWhale\Cms\Models\User
     */
    private function prepareUser(): User
    {
        return factory(User::class)->create();
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
