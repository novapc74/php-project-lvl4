@extends('layouts.app')

@section('h1')
    {{ __('Create status') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">{{ old(__('Name')) }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input class="btn btn-primary" type="submit" value="Создать">
    </form>
@endsection
