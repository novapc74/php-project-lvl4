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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $labels = DB::table('labels')
            ->orderBy('updated_at')
            ->paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!isset(\Auth::user()->id)) {
            return redirect()->back();
        }
        $labels = new Label();
        return view('labels.create', compact($labels));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabel  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLabel $request)
    {
        if (!isset(\Auth::user()->id)) {
            return redirect()->back();
        }
        $data = $request->validated();
        $label = new Label($data);
        $label->save();
        flash(__('flash.labels.cteate.success'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\View\View
     */
    public function edit(Label $label)
    {
        if (!isset(\Auth::user()->id)) {
            return redirect()->back();
        }
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabel  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreLabel $request, Label $label)
    {
        if (!isset(\Auth::user()->id)) {
            return redirect()->back();
        }
        $data = $request->validated();
        $label->fill($data);
        $label->save();
        flash(__('flash.labels.update.success'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Label $label)
    {
        if (!isset(\Auth::user()->id)) {
            return redirect()->back();
        }
        if (count($label->tasks()->get()) == 0) {
            $label->delete();
            flash(__('flash.labels.delete.success'))->success();
        } else {
            flash(__('flash.labels.failed_to_delete.error'))->error();
        }
        return redirect()->route('labels.index');
    }
}
