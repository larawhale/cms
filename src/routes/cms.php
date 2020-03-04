<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::get('/', function () {
    return 'test';
});

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => [
        SubstituteBindings::class,
    ],
], function () {
    Route::resource('entries', EntryController::class, [
        'except' => ['destroy'],
    ]);
});
