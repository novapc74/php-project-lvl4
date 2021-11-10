@extends('layouts.app')

@section('h1')
    {{ __('View task')}}: {{ $task->name}}
    @if (Auth::user())
        <a href="{{ route('tasks.edit', $task->id) }}">⚙</a>
    @endif
@endsection

@section('content')
    <p>{{ __('Name') }}: {{ $task->name }}</p>
    <p>{{ __('Status') }}: {{ App\Models\Task::find($task->id)->status->name }}</p>
    <p>{{ __('Description') }}: {{ $task->description}}</p>
    @if ($labels !== [])
        <p>{{ __('Labels') }}:</p>
        <ul>
            @foreach ($labels as $label)
                <li>{{ $label }}</li>
            @endforeach
        </ul>
    @endif
@endsection
