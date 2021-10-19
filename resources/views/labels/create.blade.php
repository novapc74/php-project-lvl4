@extends('layouts.app')

@section('h1')
    {{ __('Create label') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('labels.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}">
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="description">{{ (__('Description')) }}</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ old('description') }}</textarea>
        </div>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        {{ Form::submit(__('Create'), ['class' => "btn btn-primary"]) }}

    </form>
@endsection
