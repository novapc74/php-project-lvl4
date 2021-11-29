<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Auth;

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
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        $labels = DB::table('labels')->get();
        return view('tasks.create', compact('taskStatuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTask $request)
    {
        $task = new Task();
        $validatedTask = $request->validated();
        $user = $request->user();
        $task->createdBy()->associate($user);
        $task->fill($validatedTask);
        $task->save();
        $labels = $request->input()['labels'];
        if ($labels[0] === null) {
            unset($labels[0]);
        }
        if (count($labels) > 0) {
            $task->labels()->attach($labels);
        }
        flash(__('flash.tasks.create.success'))->success();
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
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $taskStatuses = DB::table('task_statuses')->get();
        $users = DB::table('users')->get();
        $labels = DB::table('labels')->get();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTask $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTask $request, Task $task)
    {
        if (isset($task->labels)) {
            $detachLabels = $task->labels()->get();
            $task->labels()->detach($detachLabels);
        }
        $validatedTask = $request->validated();
        $task->fill($validatedTask);
        $task->save();
        if (isset($request->labels) && $request->labels !== null) {
            $newLabels = $request->labels;
            if ($newLabels[0] === null) {
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
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $userIdAuth = Auth::id();
        $userOwnerId = $task->createdBy->id;
        if ($task->labels->count() === 0 && $userIdAuth === $userOwnerId) {
            $task->delete();
            flash(__('flash.tasks.delete.success'))->success();
        } else {
            flash(__('flash.tasks.failed_to_delete.error'))->error();
        }
        return redirect()->route('tasks.index');
    }
}
