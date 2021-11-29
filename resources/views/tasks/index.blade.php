@extends('layouts.app')

@section('h1')
    {{ __('Tasks') }}
@endsection

@section('content')
    <div class="d-flex">
        @include('tasks.filter')
        @auth
        <a href="{{ route('tasks.create')}}" class="btn btn-primary ml-auto">
            {{ __('Create task') }}
        </a>
        @endauth
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
                @auth
                <th>{{ __('Actions') }}</th>
                @endauth
            </tr>
        </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->status->name }}</td>
            <td><a href="{{ route('tasks.show', $task->id)}}">{{ $task->name }}</a></td>
            <td>{{ $task->createdBy->name }}</td>
            <td>{{ optional($task->assignedTo)->name }}</td>
            <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
            @auth
            <td>
                @can('delete', $task)

                    <a class="text-danger" data-method="DELETE" href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('Аre you sure?') }}"  rel="nofollow">
                        {{ __('Delete') }}
                    </a>
                @endcan
                    <a href="{{ route('tasks.edit', $task->id) }}" rel="nofollow">
                        {{ __('Change') }}
                    </a>
            </td>
            @endauth
        </tr>
        @endforeach
    </tbody>
    </table>
    <nav aria-label="navigation">
    {{ $tasks->links("pagination::bootstrap-4") }}
    </nav>
@endsection
