<?php

namespace LaraWhale\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use LaraWhale\Cms\Console\Commands\CreateUser;
use LaraWhale\Cms\Library\Fields\Factory as FieldFactory;
use LaraWhale\Cms\Library\Entries\Factory as EntryFactory;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cms.php', 'cms');
        
        $this->app->register(AuthServiceProvider::class);

        $this->app->register(RouteServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUser::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cms');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'cms');

        FieldFactory::$fields = config('cms.fields.classes');

        EntryFactory::loadEntries();

        $this->registerPublishPaths();
    }

    /**
     * Register paths to be published by the publish command.
     *
     * @return void
     */
    protected function registerPublishPaths(): void
    {
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/cms'),
        ], ['cms', 'cms.assets']);

        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], ['cms', 'cms.config']);

        $this->publishes([
            __DIR__ . '/../../resources/entries' => config('cms.entries.path'),
        ], ['cms', 'cms.entries']);

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/cms'),
        ], ['cms', 'cms.views']);

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/cms'),
        ], ['cms', 'cms.lang']);
    }
}
