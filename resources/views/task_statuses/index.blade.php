@extends('layouts.app')

@section('h1')
    {{ __('Statuses') }}
@endsection

@section('content')
    @if (Auth::user())
    <a href="{{ route('task_statuses.create')}}" class="btn btn-primary">
        {{ __('Create status') }}
    </a>
    @endif
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{__('Created at')}}</th>
                @if (Auth::user())
                <th>{{ __('Actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $taskStatus)
            <tr>
                <td>{{ $taskStatus->id }}</td>
                <td>{{ $taskStatus->name }}</td>
                <td>{{ date('d.m.Y', strtotime($taskStatus->created_at)) }}</td>
                <td>
                    @if (Auth::user())
                        <a href="{{ route('task_statuses.edit', $taskStatus->id) }}">
                            {{ __('Edit') }}
                        </a>
                        <a class="text-danger" href="{{ route('task_statuses.destroy', $taskStatus->id)}}" data-confirm="{{ __('Аre you sure?') }}" data-method="delete" rel="nofollow">
                            {{ __('Delete') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="navigation">
        {{ $taskStatuses->links("pagination::bootstrap-4") }}
    </nav>
@endsection
