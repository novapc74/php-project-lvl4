@extends('layouts.app')

@section('h1')
    {{ __('Change label') }}
@endsection

@section('content')

{{ Form::model($label, ['url' => route('labels.update', $label->id), 'method' => 'PATCH', 'class' => 'w-50']) }}
        @include('labels.form')
        {{ Form::submit(__('Update'), ['class' => "btn btn-primary"]) }}
{{ Form::close()}}

@endsection
