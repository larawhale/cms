<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__ . '/vendor/autoload.php';

/*
 | Use our test case, which extends from orchestral core test case, create our
 | application. Normally this is done in a bootstrap file.
 */
$app = (new LaraWhale\Cms\Tests\TestCase())->createApplication();


// Migrate the database when this has not been done yet.
if (
    ! Illuminate\Support\Facades\Schema::hasTable('migrations')
    || ! \Illuminate\Support\Facades\DB::table('migrations')->exists()
) {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
}

// Create a test user.
\LaraWhale\Cms\Models\User::firstOrCreate([
    'email' => 'test@test.test',
], [
    'name' => 'test',
    'password' => bcrypt('test'),
]);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Orchestra\Testbench\Http\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
