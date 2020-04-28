<?php

namespace LaraWhale\Cms\Tests\Feature\Logout;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\DuskTestCase;

class UiTest extends DuskTestCase
{
    /** @test */
    public function user_can_logout(): void
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/cms')
                ->click('@submit-logout')
                ->assertPathIs('/cms/login')
                ->assertGuest();
        });
    }
}
