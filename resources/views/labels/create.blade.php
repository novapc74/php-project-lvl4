@extends('layouts.app')

@section('h1')
    {{ __('Create label') }}
@endsection

@section('content')

{{ Form::open(['url' => route('labels.store'), 'method' => 'POST', 'class' => 'w-50']) }}
        @include('labels.form')
        {{ Form::submit(__('Create'), ['class' => "btn btn-primary"]) }}
{{ Form::close()}}

@endsection
