<?php

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

class UpdateTest extends TestCase
{
    /** @test */
    public function admin_can_update(): void
    {
        [$entry] = $this->prepare();

        $data = $this->requestData();

        $response = $this->makeRequest($entry, $data);

        $this->assertResponse($response);

        $this->assertDatabase($entry, $data);

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_update(): void
    {
        [$entry] = $this->prepare();

        $data = $this->requestData();

        $response = $this->makeRequest($entry, $data);

        $this->markTestIncomplete('No authentication assertion');

        $this->assertResponse($response, 403);
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    private function prepare(): array
    {
        $field = factory(Field::class)->create();

        return [$field->entry];
    }

    /**
     * Makes a request.
     *
     * @param \LaraWhale\Cms\Models\Entry  $entry
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function makeRequest(Entry $entry, array $data): TestResponse
    {
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
