@extends('layouts.app')

@include(__('flash::message'))

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
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="{{ __('Update') }}">
    </form>
@endsection
