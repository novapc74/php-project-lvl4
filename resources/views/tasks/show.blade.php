@extends('layouts.app')

@section('h1')
    {{ __('View task')}}: {{ $task->name}}
    @auth
        <a href="{{ route('tasks.edit', $task->id) }}">⚙</a>
    @endauth
@endsection

@section('content')
    <p>{{ __('Name') }}: {{ $task->name }}</p>
    <p>{{ __('Status') }}: {{ $taskStatus }}</p>
    <p>{{ __('Description') }}: {{ $task->description}}</p>
        <p>{{ __('Labels') }}:</p>
        <ul>
            @foreach ($task->labels->all() as $label)
                <li>{{ $label['name'] }}</li>
            @endforeach
        </ul>
@endsection
