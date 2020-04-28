<?php

namespace LaraWhale\Cms\Feature\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

class StoreTest extends TestCase
{
    /** @test */
    public function user_can_store(): void
    {
        [$user] = $this->prepareTest();

        $data = $this->requestData();

        $response = $this->makeRequest($user, $data);

        $this->assertResponse($response, $data['entry_type']);

        $this->assertDatabase($data);
    }

    /** @test */
    public function guest_cannot_store(): void
    {
        $data = $this->requestData();

        $response = $this->makeRequest(null, $data);

        $response->assertRedirectLogin();
    }

    /** @test */
    public function single_updates(): void
    {
        [$user] = $this->prepareTest();

        $data = $this->requestData();

        // Create a single entry and change the type in data.
        $field = factory(Field::class)->create([
            'entry_id' => factory(Entry::class)->create([
                'type' => 'single_entry',
            ]),
        ]);

        $data['entry_type'] = 'single_entry';

        $response = $this->makeRequest($user, $data);

        $this->assertResponse($response, $data['entry_type']);

        $this->assertDatabase($data);

        // Assert no extra has been created.
        $this->assertEquals(1, Entry::count());
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
     * Makes a request.
     *
     * @param  \LaraWhale\Cms\Models\User  $user
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function makeRequest(User $user = null, array $data): TestResponse
    {
        if (! is_null($user)) {
            $this->actingAs($user);
        }

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
     * @param  string  $type
     * @param  int  $status
     * @return void
     */
    private function assertResponse(TestResponse $response, string $type, int $status = 302): void
    {
        $response->assertStatus($status);

        if ($status === 302) {
            $response->assertRedirect(route('cms.entries.index', compact('type')));
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
