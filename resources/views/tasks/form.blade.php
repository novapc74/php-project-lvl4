{{ Form::label('name', __('Name')) }}
{{ Form::text('name', old('name'), ['class' => 'form-control my-2']) }}
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

{{ Form::label('description', __('Description')) }}
{{ Form::textarea('description', $task->description ?? null, ['class' => 'form-control my-2', 'cols' => '50', 'rows' => '10']) }}
@error('description')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

{{ Form::label('status_id', __('Status')), ['class' => "form-group"] }}
{{ Form::select('status_id', ['' => '----------'] + $taskStatuses->pluck('name', 'id')->all(), null, ['class' =>"form-control my-2", 'id' =>"status_id", 'name' =>"status_id"]) }}
@error('status_id')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

{{ Form::label('assigned_to_id', __('Assigned To')), ['class' => "form-group"] }}
{{ Form::select('assigned_to_id', ['' => '----------'] + $users->pluck('name', 'id')->all(), null, ['class' =>"form-control my-2", 'id' =>"assigned_to_id", 'name' =>"assigned_to_id"]) }}

{{ Form::label('labels', __('Labels')), ['class' => "form-group"] }}
{{ Form::select('labels', ['' => ''] + $labels->pluck('name', 'id')->all(), null, ['class' =>"form-control my-2", 'id' =>"assigned_to_id", 'multiple' => "", 'name' =>"labels[]"]) }}
