<?php

use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Tests\BrowserTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use LaraWhale\Cms\Library\Fields\Contracts\Field;

class CreateTest extends BrowserTestCase
{
    /** @test */
    public function admin_can_create(): void
    {
        $data = [
            'type' => 'test_entry',
            'test_key' => 'test_key_value',
        ];

        $response = $this->visitRoute('cms.entries.create', ['type' => $data['type']]);

        $this->assertMatchesHtmlSnapshot($this->response->getContent());

        $response->type($data['test_key'], 'test_key')
            ->press('Submit');

        $this->assertDatabase($data);

        $this->markTestIncomplete('No authentication nor response assertion');
    }

    /** @test */
    public function guest_cannot_create(): void
    {
        $this->markTestIncomplete('No authentication nor response assertion');
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
