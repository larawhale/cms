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

        $this->markTestIncomplete('No authentication nor response assertion');
    }

    /** @test */
    public function guest_cannot_store(): void
    {
        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->markTestIncomplete('No authentication nor response assertion');
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
        return $this->json('POST', 'cms/entries', $data);
    }

    /**
     * Returns data used in requests.
     * 
     * @return array
     */
    private function requestData(): array
    {
        $entry = factory(Entry::class)->make();

        $entryClass = $entry->toEntryClass();

        $data = $entry->toArray();

        $data ['fields'] = collect($entryClass->fields())
            ->mapWithKeys(function (Field $field) {
                $key = $field->key();

                return [$key => $key . '_value'];
            })
            ->all();

        return $data;
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
        $entry = Entry::where(Arr::except($data, ['fields']))->firstOrFail();

        foreach ($data['fields'] as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entry->id,
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
