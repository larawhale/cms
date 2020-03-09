<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => [
        'cms',
        'cms_auth',
    ],
], function () {
    Route::resource('entries', EntryController::class, [
        'except' => ['show'],
    ]);
});
