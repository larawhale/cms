<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\DuskTestCase;

class EditTest extends DuskTestCase
{
    /** @test */
    public function admin_can_edit(): void
    {
        [$entry] = $this->prepareEntry();

        $data = $this->requestData($entry);

        $this->browse(function ($browser) use ($entry, $data) {
            $url = "/cms/entries/$entry->id/edit";

            $browser->visit($url)
                ->screenshot('admin_can_edit')
                ->type('input[name=test_key]', $data['test_key'])
                ->type('input[name=another_test_key]', $data['another_test_key'])
                ->click('@submit-entry');
        });

        $this->assertDatabase($entry, $data);

        $this->markTestIncomplete('No authentication assertion');
    }

    /** @test */
    public function guest_cannot_edit(): void
    {
        //
    }

    /**
     * Prepares entry for tests.
     * 
     * @return array
     */
    private function prepareEntry(): array
    {
        $entry = factory(Entry::class)->states('with_fields')->create();

        return [$entry];
    }

    /**
     * Returns data used in requests.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return array
     */
    private function requestData(Entry $entry): array
    {
        return $entry->fields
            ->mapWithKeys(function (Field $field) {
                return [$field->key => $field->key . '_changed'];
            })
            ->all();
    }

    /**
     * Asserts the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @param  string  $fields
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
    }
}
