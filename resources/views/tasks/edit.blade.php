@extends('layouts.app')

@section('h1')
    {{ __('Chandge task') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('tasks.update', $task->id)}}" accept-charset="UTF-8" class="w-50">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group">
            <label for="name">
                {{ __('Name') }}
            </label>
            <input class="form-control" name="name" type="text" value="{{ $task->name }}" id="name">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">
                {{ __('Description') }}
            </label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description">
                {{ $task->description }}
            </textarea>
        </div>
        <div class="form-group">
            <label for="status_id">{{ __('Status') }}</label>
            <select class="form-control" id="status_id" name="status_id">
                    <option value="">----------</option>
                @foreach ($taskStatuses as $taskStatus)
                    <option value="{{ $taskStatus->id }}" @if ($relationship['statusName'] == $taskStatus->name) {{ ' selected' }} @endif>
                        {{ $taskStatus->name }}
                    </option>
                @endforeach
            </select>
            @error('status_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="assigned_to_id">{{ __('Assigned To') }}</label>
            <select class="form-control" id="assigned_to_id" name="assigned_to_id">
                    <option value="">----------</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if ($relationship['assignedToName'] == $user->name) {{ ' selected' }} @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="labels">{{ __('Labels') }}</label>
            <select class="form-control" multiple="" name="labels[]">
                <option selected="selected" value=""></option>
                @foreach ($labels as $label)
                    <option value="{{ $label->id }}" @if (in_array($label->name, $relationship['assignedToLabel'])) {{ ' selected' }} @endif>
                        {{ $label->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <input class="btn btn-primary" type="submit" value="{{ __('Update') }}">
    </form>
@endsection
