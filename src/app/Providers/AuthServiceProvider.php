<?php

namespace LaraWhale\Cms\Providers;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $config = Arr::only(config('cms'), ['guards', 'providers']);

        foreach ($config as $subject => $value) {
            foreach (config("cms.$subject") as $key => $guard) {
                $this->app->config->set("auth.$subject.$key", $guard);
            }
        }
    }
}
