@extends('layouts.app')

@section('h1')
    {{ __('Create status') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input class="form-control" name="name" type="text" id="name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="Создать">
    </form>
@endsection
