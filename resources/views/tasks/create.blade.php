@extends('layouts.app')

@section('h1')
    {{ __('Create task') }}
@endsection

@section('content')

{{ Form::open(['url' => route('tasks.store'), 'method' => 'POST', 'accept-charset' => "UTF-8", 'class' => 'w-50']) }}

    @include('tasks.form')
    {{ Form::submit(__('Create'), ['class' => "btn btn-primary my-3"]) }}

{{ Form::close() }}
@endsection
