<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTask;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')
            ->orderBy('id', 'desc')
            ->paginate();
        $relationship = [];
        foreach ($tasks as $task) {
            $task = Task::find($task->id);
            $relationship[$task->id] = [
                'status' => $task->status->name,
                'createdBy' => $task->createdBy->name,
                'assignedTo' => $task->assignedTo->name ?? null,
            ];
        }
        return view('tasks.index', compact('tasks', 'relationship'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = new Task();
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        $labels = DB::table('labels')->get();
        return view('tasks.create', compact('tasks', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request)
    {
        $data = $request->input();
        $newTask = new Task();
        $validated = $request->validated();
        $validated['created_by_id'] = \Auth::user()->id;
        $newTask->fill($validated);
        $newTask->save();
        $newLabels = $data['labels'];
        if ($newLabels[0] == null) {
            unset($newLabels[0]);
        }
        if (count($newLabels) > 0) {
            $newTask->labels()->attach($newLabels);
        }
        flash(__('flash.tasks.cteate.success'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $labels = [];
        foreach ($task->labels as $labelName) {
            $labels[] = $labelName->name;
        }
        return view('tasks.show', compact('task', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (!\Auth::user()) {
            flash(__('flash.tasks.this_action_is_unauthorized'))->error();
            return redirect()->route('tasks.show', compact('task'));
        }
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        $labels = DB::table('labels')->get();
        $taskCheck = Task::find($task->id);
        $assignedToLabelNames = [];
        foreach ($taskCheck->labels as $labelName) {
            $assignedToLabelNames[] = $labelName->name;
        }
        $relationship = [
            'assignedToName' => $taskCheck->assignedTo->name ?? null,
            'statusName' => $taskCheck->status->name ?? null,
            'assignedToLabel' => $assignedToLabelNames,
        ];
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels', 'relationship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTask $request, Task $task)
    {
        $data = $request->input();
        $updatedTask = Task::find($task->id);
        $updatedTask->labels()->detach($updatedTask->labels);
        $validated = $request->validated();
        $updatedTask->fill($validated);
        $updatedTask->save();
        $newLabels = $data['labels'];
        if ($newLabels[0] == null) {
            unset($newLabels[0]);
        }
        if (count($newLabels) > 0) {
            $updatedTask->labels()->attach($newLabels);
        }
        flash(__('flash.tasks.update.success'))->success();
        return redirect()->route('tasks.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $labels = $task->labels()->get();
        if ($task && count($labels) == 0) {
            $task->delete();
            flash(__('flash.tasks.delete.success'))->success();
        } else {
            flash(__('flash.tasks.failed_to_delete.error'))->error();
        }
        return redirect()->route('tasks.index');
    }
}
