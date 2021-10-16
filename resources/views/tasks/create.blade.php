@extends('layouts.app')

@section('h1')
    {{ __('Create task') }}
@endsection

@section('content')
        <form method="POST" action="{{ route('tasks.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description"></textarea>
        </div>

        <div class="form-group">
            <label for="status_id">{{ __('Status') }}</label>
        <select class="form-control" id="status_id" name="status_id">
            <option selected="selected" value="">----------</option>
            @foreach ($taskStatuses as $taskStatus)
                <option value="{{ $taskStatus->id }}">{{ $taskStatus->name }}</option>
            @endforeach
        </select>
    </div>

        <div class="form-group">
    <label for="assigned_to_id">{{ __('Performer') }}</label>
    <select class="form-control" id="assigned_to_id" name="assigned_to_id">
        <option selected="selected" value="">----------</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
   </select>
    </div>
{{--

    <div class="form-group">
        <label for="labels">{{ __('Labels') }}</label>
        <select class="form-control" multiple="" name="labels[]">
        <option selected="selected" value="">----------</option>
        @foreach ($labels as $label)
            <option value="{{ $label->id }}">{{ $label->name }}</option>
        @endforeach
        </select>
    </div>
--}}
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </form>
@endsection

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror






