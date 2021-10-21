@extends('layouts.app')

@section('h1')
    {{ __('Create status') }}
@endsection

@section('content')
    {{ Form::open(['url' => route('task_statuses.store'), 'method' => 'POST', 'class' => 'w-50']) }}
        @include('task_statuses.form')
        {{ Form::submit(__('Create'), ['class' => "btn btn-primary"]) }}
    {{ Form::close()}}
@endsection
