<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use LaraWhale\Cms\Http\Controllers\LoginController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => ['cms'],
], function () {
    Route::group([
        'middleware' => ['cms_guest'],
    ], function () {
        Route::get('login', [
            'as' => 'login',
            'uses' => LoginController::class . '@showLoginForm',
        ]);

        Route::post('login', LoginController::class . '@login');
    });

    Route::group([
        // TODO: Disabling this is temporary.
        'middleware' => ['cms_auth'],
    ], function () {
        Route::post('logout', [
            'as' => 'logout',
            'uses' => LoginController::class . '@logout',
        ]);

        Route::get('', function () {
            // TODO: Should not be styleguide.
            return view('cms::styleguide.index');
        })->name('home');

        Route::resource('entries', EntryController::class, [
            'except' => ['show'],
        ]);
    });
});
