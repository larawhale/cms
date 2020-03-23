<?php

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;


// Create an application using the test case. This way, all the necessary
// settings and providers are registered.
$app = (new TestCase())->createApplication();

// Republish all the publishables on every request so changes are seen
// immediately. This might add some slower performance, but it does not matter
// that much since this file is for testing purposes only.
Artisan::call('vendor:publish', [
    '--force' => true,
    '--tag' => 'cms',
]);

// Migrate the database when this has not been done yet.
if (
    ! Schema::hasTable('migrations')
    || ! DB::table('migrations')->exists()
) {
    Artisan::call('migrate:fresh');
}

// Make sure there is a cms user available.
User::firstOrCreate([
    'email' => 'test@test.test',
], [
    'name' => 'test',
    'password' => bcrypt('test'),
]);

// TODO: Not sure yet if this is necessary.
// In order to make requests a http kernel should be registered..
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Orchestra\Testbench\Http\Kernel::class
);

// Set session drive to cookie so it is persisted. The testbench Laravel
// installation has it set to array by default.
$app->config->set('session.driver', 'cookie');

// Register debug bar and enable it.
$app->register(Barryvdh\Debugbar\ServiceProvider::class);

$app->make(Barryvdh\Debugbar\LaravelDebugbar::class)->enable();

$app->config->set('app.debug', false);

return $app;
