<?php

namespace LaraWhale\Cms\Tests\Feature\Login;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\DuskTestCase;

class UiTest extends DuskTestCase
{
    /** @test */
    public function user_can_logout(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $this->browse(function ($browser) {
            $browser->visit('/cms')
                ->click('@submit-logout')
                ->assertPathIs('/cms/login')
                ->assertGuest();
        });
    }
}
