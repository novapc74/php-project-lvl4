<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTask;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Contracts\Auth\Authenticatable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('assigned_to_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('status_id'),
            ])
            ->orderBy('updated_at')
            ->paginate(15);
        $relationship = [];
        foreach ($tasks->all() as $task) {
            $relationship[$task->id] = [
                'status' => $task->status->name ?? null,
                'createdBy' => $task->createdBy->name ?? null,
                'assignedTo' => $task->assignedTo->name ?? null,
            ];
        }
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        return view('tasks.index', compact('tasks', 'relationship', 'taskStatuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
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
     * @param  \App\Http\Requests\StoreTask  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTask $request)
    {
        $newTask = new Task();
        $data = $request->validated();
        if (isset(\Auth::user()->id)) {
            $data['created_by_id'] = \Auth::user()->id;
        }
        $newTask->fill($data);
        $newTask->save();
        $labels = $request->input()['labels'];
        if ($labels[0] == null) {
            unset($labels[0]);
        }
        if (count($labels) > 0) {
            $newTask->labels()->attach($labels);
        }
        flash(__('flash.tasks.cteate.success'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function show(Task $task)
    {
        $labels = [];
        if (isset($task->labels)) {
            foreach ($task->labels as $labelName) {
                $labels[] = $labelName->name;
            }
        }
        return view('tasks.show', compact('task', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        $labels = DB::table('labels')->get();
        $assignedToLabelNames = [];
        foreach ($task->labels()->get() as $labelName) {
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
     * @param  \App\Http\Requests\StoreTask  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreTask $request, Task $task)
    {
        $task->labels()->detach($task->labels()->get());
        $data = $request->validated();
        $task->fill($data);
        $task->save();
        if ($request->labels !== null) {
            $newLabels = $request->labels;
            if ($newLabels[0] == null) {
                unset($newLabels[0]);
            }
            if (count($newLabels) > 0) {
                $task->labels()->attach($newLabels);
            }
        }
        flash(__('flash.tasks.update.success'))->success();
        return redirect()->route('tasks.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $labels = $task->labels()->get();
        if (count($labels) == 0) {
            $task->delete();
            flash(__('flash.tasks.delete.success'))->success();
        } else {
            flash(__('flash.tasks.failed_to_delete.error'))->error();
        }
        return redirect()->route('tasks.index');
    }
}
