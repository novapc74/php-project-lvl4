@extends('layouts.app')

@include(__('flash::message'))

@section('h1')
    {{ __('View task')}}: {{ $task->name}}
    <a href="{{ route('tasks.edit', $task->id) }}">⚙</a>
@endsection;

@section('content')
    <p>{{ __('Name') }}: {{ $task->name }}</p>
    <p>{{ __('Statys') }}: {{ App\Models\Task::find($task->id)->status->name }}</p>
    <p>{{ __('Description') }}: {{ $task->description}}</p>
@endsection
