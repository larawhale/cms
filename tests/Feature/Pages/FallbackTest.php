<?php

namespace LaraWhale\Cms\Tests\Feature\Pages;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\DuskTestCase;

class FallbackTest extends DuskTestCase
{
    /** @test */
    public function not_found_cms(): void
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/cms/not-found')
                ->screenshot('not_found')
                ->assertSee('404');
        });
    }

    /** @test */
    public function not_found_cms_guest(): void
    {
        $this->browse(function ($browser) {
            // Request without user and get redirected.
            $browser->visit('/cms/not-found')
                ->assertPathIs('/cms/login');
        });
    }

    /** @test */
    public function not_found_default(): void
    {
        $this->browse(function ($browser) {
            // Request a non cms route without a cms user.
            $browser->visit('/not-found')
                ->screenshot('not_found_default')
                ->assertSee('404');
        });
    }
}
