@extends('layouts.app')

@section('h1')
    {{ __('Tasks') }}
@endsection

@section('content')
    <a href="{{ route('tasks.create')}}" class="btn btn-primary">
    {{ __('Create task') }}
    </a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Creator') }}</th>
                <th>{{ __('Assigned To') }}</th>
                <th>{{ __('Created at') }}</th>
                @if (Auth::user())
                <th>{{ __('Actions') }}</th>
                @endif
            </tr>
        </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $relationship[$task->id]['status'] }}</td>
            <td><a href="{{ route('tasks.show', $task->id)}}">{{ $task->name }}</a></td>
            <td>{{ $relationship[$task->id]['createdBy'] }}</td>
            <td>{{ $relationship[$task->id]['assignedTo'] }}</td>
            <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
            <td>
                @if (Auth::user())
                    <a href="{{ route('tasks.edit', $task->id) }}">
                        {{ __('Chandge') }}
                    </a>
                    @if (Auth::user()->email == App\Models\Task::find($task->id)->createdBy->email)
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="text-danger">{{ __('Delete') }}</button>
                    </form>
                    @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <nav aria-label="navigation">
    {{ $tasks->links("pagination::bootstrap-4") }}
    </nav>
@endsection
