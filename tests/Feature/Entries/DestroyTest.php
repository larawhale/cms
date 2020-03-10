<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

class DestroyTest extends TestCase
{
    /** @test */
    public function user_can_destroy(): void
    {
        [$user, $entry] = $this->prepareTest();

        $response = $this->makeRequest($user, $entry);

        $this->assertResponse($response);

        $this->assertDatabase($entry);
    }

    /** @test */
    public function guest_cannot_destroy(): void
    {
        [$user, $entry] = $this->prepareTest();

        $response = $this->makeRequest(null, $entry);

        $this->markTestIncomplete('No authentication assertion');

        $this->assertResponse($response, 401);
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    private function prepareTest(): array
    {
        $user = factory(User::class)->create();

        $entry = factory(Entry::class)->create();

        return [$user, $entry];
    }

    /**
     * Makes a request.
     *
     * @param  \LaraWhale\Cms\Models\User  $user
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function makeRequest(User $user = null, Entry $entry): TestResponse
    {
        $request = $this;

        if (! is_null($user)) {
            $request = $this->actingAs($user);
        }

        return $request->delete("cms/entries/$entry->id");
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
