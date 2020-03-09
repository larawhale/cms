<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

class DestroyTest extends TestCase
{
    /** @test */
    public function admin_can_destroy(): void
    {
        [$entry] = $this->prepareEntry();

        $response = $this->makeRequest($entry);

        $this->assertResponse($response);

        $this->assertDatabase($entry);

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_destroy(): void
    {
        [$entry] = $this->prepareEntry();

        $response = $this->makeRequest($entry);

        $this->markTestIncomplete('No authentication assertion');

        $this->assertResponse($response, 403);
    }

    /**
     * Prepares entry for tests.
     * 
     * @return array
     */
    private function prepareEntry(): array
    {
        $entry = factory(Entry::class)->create();

        return [$entry];
    }

    /**
     * Makes a request.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function makeRequest(Entry $entry): TestResponse
    {
        return $this->delete("cms/entries/$entry->id");
    }

    /**
     * Asserts a response.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse  $response
     * @param  int  $status
     * @return void
     */
    private function assertResponse(TestResponse $response, int $status = 201): void
    {
        $response->assertStatus($status);

        if ($status === 201) {
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
