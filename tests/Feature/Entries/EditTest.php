<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\DuskTestCase;

class EditTest extends DuskTestCase
{
    /** @test */
    public function user_can_edit(): void
    {
        [$user, $entry] = $this->prepareTest();

        $data = $this->requestData($entry);

        $this->browse(function ($browser) use ($user, $entry, $data) {
            $url = "/cms/entries/$entry->id/edit";

            $browser->loginAs($user)
                ->visit($url)
                ->screenshot('user_can_edit')
                ->type('input[name=test_key]', $data['test_key'])
                ->type('input[name=another_test_key]', $data['another_test_key'])
                ->click('@submit-entry')
                ->assertPathIs('/cms/entries');
        });

        $this->assertDatabase($entry, $data);
    }

    /** @test */
    public function guest_cannot_edit(): void
    {
        [$user, $entry] = $this->prepareTest();

        // Request without user.
        $response = $this->get("/cms/entries/$entry->id/edit");

        $response->assertRedirectLogin();
    }

    /**
     * Prepares for tests.
     *
     * @return array
     */
    private function prepareTest(): array
    {
        $user = factory(User::class)->create();

        $entry = factory(Entry::class)->state('with_fields')->create([
            'type' => 'test_entry',
        ]);

        return [$user, $entry];
    }

    /**
     * Returns data used in requests.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return array
     */
    private function requestData(Entry $entry): array
    {
        $entry->load('fields');

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
