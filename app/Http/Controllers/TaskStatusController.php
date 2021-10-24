<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTaskStatus;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = DB::table('task_statuses')
            ->orderBy('updated_at')
            ->paginate();
        return response()
            ->view('task_statuses.index', compact('taskStatuses'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return response()
            ->view('task_statuses.create', compact('taskStatus'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskStatus $request)
    {
        $taskStatus = $request->input();
        $newTaskStatus = new TaskStatus();
        $validated = $request->validated();
        $newTaskStatus->fill($validated);
        $newTaskStatus->save();
        flash(__('flash.task_status.create.success'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        return response('page not found', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return response()
            ->view('task_statuses.edit', compact('taskStatus'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskStatus $request, TaskStatus $taskStatus)
    {
        $taskStatus = TaskStatus::find($taskStatus->id);
        $validated = $request->validated();
        $taskStatus->name = $validated['name'];
        $taskStatus->save();
        flash(__('flash.task_status.update.success'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (TaskStatus::find($taskStatus->id)->tasks->all() == []) {
            $taskStatus->delete();
            flash(__('flash.task_status.delete.success'))->success();
        } else {
            flash(__('flash.task_status.failed_to_delete.error'))->error();
        }
        return redirect()->route('task_statuses.index')->withStatus('200');
    }
}
