<?php

namespace LaraWhale\Cms\Tests\Feature\Entries;

use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\DuskTestCase;

class RouteTest extends DuskTestCase
{
    /** @test */
    public function guest_can_show_route(): void
    {
        $route = 'test-value';

        factory(Field::class)->create([
            'key' => 'test_key',
            'type' => config('cms.route_field_type'),
            'value' => $route,
        ]);

        $this->browse(function ($browser) use ($route) {
            $browser->visit($route)
                ->screenshot('guest_can_show_route')
                ->assertSee("Route from entry: $route");
        });
    }
}
