@extends('layouts.app')

@section('title', 'Регистрация')

@section('header', 'Регистрация')

@section('content')

{{ Form::open(['url' => route('users.store'), 'method' => 'POST']) }}
    {{ Form::label('name', 'Имя') }}
    {{ Form::text('name') }}<br>
    {{ Form::label('email', 'Email') }}
    {{ Form::text('email') }}<br>
    {{ Form::label('password', 'Пароль') }}
    {{ Form::password('password') }}<br>
    {{ Form::label('password', 'Подтверждение') }}
    {{ Form::password('passwordConfirmation') }}<br>
    {{ Form::submit('Зарегистрировать') }}
{{ Form::close() }}
@endsection

@include('flash::message')
