<?php

namespace LaraWhale\Cms\Tests\Feature\Logout;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    public function user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $this->post('cms/logout')
            ->assertRedirectLogin();

        $this->assertGuest();
    }
}
