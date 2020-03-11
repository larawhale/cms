<?php

namespace LaraWhale\Cms\Tests\Feature\Login;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\DuskTestCase;

class GetTest extends DuskTestCase
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

        $this->browse(function ($browser) use ($user, $data) {
            $browser->visit('/cms/login')
                ->screenshot('guest_can_login')
                ->type('input[name=email]', $data['email'])
                ->type('input[name=password]', $data['password'])
                ->click('@submit-login')
                ->assertPathIs('/cms')
                ->assertAuthenticatedAs($user);
        });
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    private function prepareTest(): array
    {
        $user = factory(User::class)->create([
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
