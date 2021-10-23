<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLabel;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = DB::table('labels')
            ->orderBy('id', 'desc')
            ->paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labels = new Label();
        return view('labels.create', compact($labels));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLabel $request)
    {
        $data = $request->input();
        $label = new Label();
        $validated = $request->validated();
        $label->fill($validated);
        $label->save();
        flash(__('flash.labels.cteate.success'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        if (!\Auth::user()) {
            flash(__('flash.tasks.this_action_is_unauthorized'))->error();
            return redirect()->route('tasks.show', compact('task'));
        }
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLabel $request, Label $label)
    {
        $data = $request->input();
        $validated = $request->validated();
        $label->fill($validated);
        $label->save();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $tasks = $label->tasks()->get();
        if ($label && count($tasks) == 0) {
            $label->delete();
            flash(__('flash.labels.delete.success'))->success();
        } else {
            flash(__('flash.labels.failed_to_delete.error'))->error();
        }
        return redirect()->route('labels.index');
    }
}