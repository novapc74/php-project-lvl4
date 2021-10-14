@extends('layouts.app')

@section('content')
@include('flash::message')

<main class="container py-4">
    <h1 class="mb-5">{{ __('Tasks') }}</h1>
    <a href="{{ route('tasks.create')}}" class="btn btn-primary">
    {{ __('Create task') }}
    </a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{-- __('Creator') --}}</th>
                <th>{{ __('Performer') }}</th>
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
                <td>{{ 'Статус' }}</td>
                <td>{{ $task->name }}</td>
                <td>{{-- Auth::user()->name --}}</td>
                <td>{{ 'Исполнитель' }}</td>
                <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
                <td>
                    @if (Auth::user())
                        <a class="text-danger" href="{{ route('tasks.edit', $task->id) }}">
                            {{ __('Chandge') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
