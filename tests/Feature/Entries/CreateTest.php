<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\DuskTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class CreateTest extends DuskTestCase
{
    /** @test */
    public function admin_can_create(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/cms/entries/create?type=test_entry')
                ->screenshot('admin_can_create');
        });
    }

    /** @test */
    public function guest_cannot_create(): void
    {
        $this->markTestIncomplete('No authentication assertion');
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
     * Asserts a response.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse  $response
     * @param  int  $status
     * @return void
     */
    private function assertResponse(TestResponse $response, int $status = 200): void
    {
        $response->assertStatus($status);
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
