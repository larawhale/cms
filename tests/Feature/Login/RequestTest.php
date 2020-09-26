<?php

namespace LaraWhale\Cms\Tests\Feature\Login;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * The password used to create a user and login.
     *
     * @var string
     */
    private string $password = 'password';

    /** @test */
    public function guest_can_login(): void
    {
        [$user] = $this->prepareTest();

        $data = $this->requestData($user);

        $response = $this->post('cms/login', $data)
            ->assertRedirectHome();

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Prepares for tests.
     *
     * @return array
     */
    private function prepareTest(): array
    {
        $user = User::factory()->create([
            'password' => bcrypt($this->password),
        ]);

        return [$user];
    }

    /**
     * Returns data used in requests.
     *
     * @param  \LaraWhale\Cms\Models\User  $user
     * @return array
     */
    private function requestData(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => $this->password,
        ];
    }
}
