<?php

namespace LaraWhale\Cms\Providers;

use LaraWhale\Cms\Models\Entry;
use Illuminate\Support\Facades\Route;
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

        $this->middlewareGroup('cms', config('cms.routes.middleware'));

        $this->aliasMiddleware('cms_auth', config('cms.routes.cms_auth_middleware'));

        $this->aliasMiddleware('cms_guest', config('cms.routes.cms_guest_middleware'));

        Route::model('entry', Entry::class);
    }
}
