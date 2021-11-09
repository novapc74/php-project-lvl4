<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTaskStatus;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $taskStatuses = DB::table('task_statuses')
            ->orderBy('updated_at')
            ->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskStatus  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskStatus $request)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        $validatedTaskStatus = $request->validated();
        $newTaskStatus = new TaskStatus($validatedTaskStatus);
        $newTaskStatus->save();
        flash(__('flash.task_status.create.success'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return void
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskStatus  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreTaskStatus $request, TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        $validatedTaskStatus = $request->validated();
        $taskStatus->fill($validatedTaskStatus);
        $taskStatus->save();
        flash(__('flash.task_status.update.success'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        if (count($taskStatus->tasks()->get()) == 0) {
            $taskStatus->delete();
            flash(__('flash.task_status.delete.success'))->success();
        } else {
            flash(__('flash.task_status.failed_to_delete.error'))->error();
        }
        return redirect()->route('task_statuses.index');
    }
}
