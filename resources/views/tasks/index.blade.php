@extends('layouts.app')

@section('h1')
    {{ __('Tasks') }}
@endsection

@section('content')
    <div class="d-flex">
        @include('filter')
        @if (Auth::user())
        <a href="{{ route('tasks.create')}}" class="btn btn-primary ml-auto">
            {{ __('Create task') }}
        </a>
        @endif
    </div>
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
                @if (Auth::user()->email == App\Models\Task::find($task->id)->createdBy->email)
                    <a class="text-danger" data-method="DELETE" href="{{ route('tasks.destroy', $task->id) }}" data-confirm="{{ __('Аre you sure?') }}"  rel="nofollow">
                        {{ __('Delete') }}
                    </a>
                @endif
                    <a href="{{ route('tasks.edit', $task->id) }}" rel="nofollow">
                        {{ __('Chandge') }}
                    </a>

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
