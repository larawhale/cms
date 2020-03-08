<?php

namespace LaraWhale\Cms\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use LaraWhale\Cms\Models\Entry;
use Illuminate\Routing\Controller;
use LaraWhale\Cms\Http\Requests\Entries\StoreRequest;
use LaraWhale\Cms\Http\Requests\Entries\UpdateRequest;
use LaraWhale\Cms\Library\Entries\Entry as EntryClass;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        $data = [
            'type' => $request->get('entry_type'),
            'fields' => Arr::except($request->validated(), ['entry_type']),
        ];

        EntryClass::save(new Entry, $data);

        return redirect()->route('cms.entries.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        //
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

        return redirect()->route('cms.entries.index');
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
        //
    }
}
