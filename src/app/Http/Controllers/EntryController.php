<?php

namespace LaraWhale\Cms\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Library\Entries\Factory;
use LaraWhale\Cms\Http\Requests\Entries\StoreRequest;
use LaraWhale\Cms\Http\Requests\Entries\UpdateRequest;
use LaraWhale\Cms\Library\Entries\Entry as EntryClass;
use LaraWhale\Cms\Exceptions\EntryConfigNotFoundException;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type');

        // The index page is only available for types that exist.
        if (is_null($type)
            || ! Factory::exists($type)
        ) {
            abort(404);
        }
        
        $entryClass = Factory::make($type);

        // The index page should not be available to single type entries.
        // Redirect to create or edit according to its exsistence.
        if ($entryClass->single()) {
            $entry = Entry::type($request->get('type'))->latest()->first();

            $route =  is_null($entry)
                ? ['cms.entries.create', compact('type')]
                : ['cms.entries.edit', compact('entry')];

            return redirect()->route(...$route);
        }

        $entries = Entry::type($type)->latest('updated_at')->paginate();

        return view('cms::entries.index', compact('entryClass', 'entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->get('type');

        // The create page is only available for types that exist.
        if (is_null($type)
            || ! Factory::exists($type)
        ) {
            abort(404);
        }
        
        $entryClass = Factory::make($type);

        // The create page should only be available to single type entries that
        // are not yet stored in the database. Redirect to edit according to
        // its existence.
        if ($entryClass->single()) {
            $entry = Entry::type($request->get('type'))->latest()->first();

            if (! is_null($entry)) {
                return redirect()->route('cms.entries.edit', compact('entry'));
            }
        }

        return view('cms::entries.create', [
            'entry' => new Entry(compact('type')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \LaraWhale\Cms\Http\Requests\Entries\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $type = $request->get('entry_type');

        $data = [
            'type' => $type,
            'fields' => Arr::except($request->validated(), ['entry_type']),
        ];

        $entry = new Entry;
        
        $entryClass = Factory::make($type);

        // Only one single entry type should exist. Find it and update or
        // create a new one.
        if ($entryClass->single()) {
            $entry = Entry::type($type)->latest()->first()
                ?? new Entry;
        }

        EntryClass::save($entry, $data);

        return redirect()->route('cms.entries.index', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        return view('cms::entries.edit', compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \LaraWhale\Cms\Http\Requests\Entries\UpdateRequest  $request
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Entry $entry)
    {
        $data = [
            'fields' => $request->validated(),
        ];

        EntryClass::save($entry, $data);

        return redirect()->route('cms.entries.index', [
            'type' => $entry->type,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        $type = $entry->type;

        $entry->delete();

        return redirect()->route('cms.entries.index', compact('type'));
    }
}
