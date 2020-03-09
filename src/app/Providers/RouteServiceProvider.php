<?php

namespace LaraWhale\Cms\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        $this->loadRoutesFrom(__DIR__ . '/../../routes/cms.php');

        $this->middlewareGroup('cms', config('cms.middleware'));

        $this->aliasMiddleware('cms_auth', config('cms.cms_auth_middleware'));

        $this->aliasMiddleware('cms_guest', config('cms.cms_guest_middleware'));
    }
}
