<?php

namespace LaraWhale\Cms\Feature\Entries;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Tests\TestResponse;

class UpdateTest extends TestCase
{
    /** @test */
    public function admin_can_update(): void
    {
        [$user, $entry] = $this->prepareTest();

        $data = $this->requestData();

        $response = $this->makeRequest($user, $entry, $data);

        $this->assertResponse($response, $entry->type);

        $this->assertDatabase($entry, $data);
    }

    /** @test */
    public function guest_cannot_update(): void
    {
        [$user, $entry] = $this->prepareTest();

        $data = $this->requestData();

        // Make request without user.
        $response = $this->makeRequest(null, $entry, $data);

        $response->assertRedirectLogin();
    }

    /**
     * Prepares for tests.
     *
     * @return array
     */
    private function prepareTest(): array
    {
        $user = User::factory()->create();

        $field = Field::factory()->create([
            'key' => 'test_key',
            'type' => 'test_key',
            'entry_id' => Entry::factory()->create([
                'type' => 'test_entry',
            ]),
        ]);

        return [$user, $field->entry];
    }

    /**
     * Makes a request.
     *
     * @param \LaraWhale\Cms\Models\Entry  $entry
     * @param  array  $data
     * @return \LaraWhale\Cms\Tests\TestResponse
     */
    private function makeRequest(User $user = null, Entry $entry, array $data): TestResponse
    {
        if (! is_null($user)) {
            $this->actingAs($user);
        }

        return $this->patch("cms/entries/$entry->id", $data);
    }

    /**
     * Returns data used in requests.
     *
     * @return array
     */
    private function requestData(): array
    {
        return [
            'test_key' => 'diff_test_key_value',
            'another_test_key' => 'diff_another_test_value',
        ];
    }

    /**
     * Asserts a response.
     *
     * @param  \LaraWhale\Cms\Tests\TestResponse  $response
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
     * @param \LaraWhale\Cms\Models\Entry  $entry
     * @param  array  $fields
     * @return void
     */
    private function assertDatabase(Entry $entry, array $fields): void
    {
        foreach ($fields as $key => $value) {
            $this->assertDatabaseHas('fields', [
                'entry_id' => $entry->id,
                'key' => $key,
                'value' => $value,
            ]);
        }

        $this->assertEquals(
            count($fields),
            $entry->fields()->count(),
        );
    }
}
