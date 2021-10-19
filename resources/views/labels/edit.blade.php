@extends('layouts.app')

@section('h1')
    {{ __('Chandge status') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id)}}" accept-charset="UTF-8" class="w-50">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group">
            <label for="name">
                {{ __('Name') }}
            </label>
            <input class="form-control" name="name" type="text" value="{{ $taskStatus->name }}" id="name">
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input class="btn btn-primary" type="submit" value="{{ __('Update') }}">
    </form>
@endsection
