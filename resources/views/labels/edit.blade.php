@extends('layouts.app')

@section('h1')
    {{ __('Chandge label') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('labels.update', $label->id)}}" accept-charset="UTF-8" class="w-50">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group">
            <label for="name">
                {{ __('Name') }}
            </label>
            <input class="form-control" name="name" type="text" value="{{ $label->name }}" id="name">
            <div class="form-group">
                <label for="description">{{ (__('Description')) }}</label>
                <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ $label->description }}</textarea>
            </div>
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input class="btn btn-primary" type="submit" value="{{ __('Update') }}">
    </form>
@endsection
