<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Tests\TestResponse;

class DestroyTest extends TestCase
{
    /** @test */
    public function user_can_destroy(): void
    {
        [$user, $entry] = $this->prepareTest();

        $response = $this->makeRequest($user, $entry);

        $this->assertResponse($response, $entry->type);

        $this->assertDatabase($entry);
    }

    /** @test */
    public function guest_cannot_destroy(): void
    {
        [$user, $entry] = $this->prepareTest();

        // Do not make a request with a user.
        $response = $this->makeRequest(null, $entry);

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

        $entry = Entry::factory()->create();

        return [$user, $entry];
    }

    /**
     * Makes a request.
     *
     * @param  \LaraWhale\Cms\Models\User  $user
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \LaraWhale\Cms\Tests\TestResponse
     */
    private function makeRequest(User $user = null, Entry $entry): TestResponse
    {
        if (! is_null($user)) {
            $this->actingAs($user);
        }

        return $this->delete("cms/entries/$entry->id");
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
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return void
     */
    private function assertDatabase(Entry $entry): void
    {
        $this->assertDatabaseMissing('entries', [
            'id' => $entry->id,
        ]);
    }
}
