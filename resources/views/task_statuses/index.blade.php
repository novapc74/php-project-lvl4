@extends('layouts.app')

@section('content')
@include('flash::message')

<main class="container py-4">
    <h1 class="mb-5">{{ __('Statuses') }}</h1>
    <a href="{{ route('task_statuses.create')}}" class="btn btn-primary">
    {{ __('Create ststus') }}
    </a>
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
                <td>{{ $taskStatus->created_at }}</td>
                <td>
                    @if (Auth::user())
                        <form action="{{ route('task_statuses.destroy', $taskStatus->id) }}" method="POST" >
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="text-danger">{{ __('Delete') }}</button>
                        </form>

<!--                         <a class="text-danger" href="{{ route('task_statuses.destroy', $taskStatus->id) }}" data-confirm="Вы уверены?" data-method="delete">
                            {{ __('Delete') }}
                        </a> -->
                        <a href="{{ route('task_statuses.edit', $taskStatus->id) }}">
                            {{ __('Edit') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
