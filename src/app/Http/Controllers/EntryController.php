<?php

namespace LaraWhale\Cms\Http\Controllers;

use Illuminate\Http\Request;
use LaraWhale\Cms\Models\Entry;
use Illuminate\Routing\Controller;
use LaraWhale\Cms\Http\Requests\Entries\StoreRequest;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \LaraWhale\Cms\Http\Requests\Entries\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        dd($request->validated());
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraWhale\Cms\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $entry)
    {
        //
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
