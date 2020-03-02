<?php

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class StoreTest extends TestCase
{
    /** @test */
    public function admin_can_store(): void
    {
        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->assertResponse($response);

        $this->assertDatabase($data);

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_store(): void
    {
        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->markTestIncomplete('No authentication assertion');
        // $this->assertResponse($response, 403);
    }

    /**
     * Makes a request.
     *
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function makeRequest(array $data): TestResponse
    {
        return $this->post('cms/entries', $data);
    }

    /**
     * Returns data used in requests.
     * 
     * @return array
     */
    private function requestData(): array
    {
        return [
            'entry_type' => 'test_entry',
            'test_key' => 'test_key_value',
            'another_test_key' => 'another_test_value',
        ];
    }

    /**
     * Asserts a response.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse  $response
     * @param  int  $status
     * @return void
     */
    private function assertResponse(TestResponse $response, int $status = 302): void
    {
        $response->assertStatus($status);

        if ($status === 302) {
            $response->assertRedirect(route('cms.entries.index'));
        }
    }

    /**
     * Asserts the database.
     *
     * @param  array  $data
     * @return void
     */
    private function assertDatabase(array $data): void
    {
        $entry = Entry::where('type', $data['entry_type'])->firstOrFail();

        $fields = Arr::except($data, ['entry_type']);

        foreach ($fields as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entry->id,
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
