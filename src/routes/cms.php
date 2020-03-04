<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

use LaraWhale\Cms\Models\Entry;
Route::get('/', function () {
    $type = request()->get('type');

    return view('cms::entries.create', [
        'entry' => new Entry(compact('type')),
    ]);
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
