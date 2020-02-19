<?php

namespace LaraWhale\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use LaraWhale\Cms\Library\Fields\Factory;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/cms.php', 'cms'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cms');

        Factory::$fields = config('cms.fields');
    }
}
