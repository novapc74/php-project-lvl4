@extends('layouts.app')

@section('h1')
    {{ __('Change task') }}
@endsection

@section('content')

{{ Form::model($task, ['url' => route('tasks.update', $task->id), 'method' => 'PATCH', 'accept-charset' => "UTF-8", 'class' => 'w-50']) }}
    @include('tasks.form')
    {{ Form::submit(__('Update'), ['class' => "btn btn-primary my-3"]) }}

{{ Form::close() }}

@endsection
