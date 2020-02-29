<?php

use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

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
        return $this->json('POST', 'entries', $data);
    }

    /**
     * Returns data used in requests.
     * 
     * @return array
     */
    private function requestData(): array
    {
        return [];
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
    }

    /**
     * Asserts the database.
     *
     * @param  array  $data
     * @return void
     */
    private function assertDatabase(array $data): void
    {
        $this->assertDatabaseHas('enries', $data);

        $this->assertDatabaseHas('fields', $data);
    }
}
