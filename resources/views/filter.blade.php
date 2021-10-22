{{ Form::open(['url' => route('tasks.index'), 'method' => 'GET', 'class' => 'form-inline', 'accept-charset' => "UTF-8"]) }}

{{ Form::select('status_id', ['' => __('Status')] + $taskStatuses->pluck('name', 'id')->all(), null, ['class' =>"form-control mr-2", 'id' =>"status_id", 'name' =>"filter[status_id]"]) }}

{{ Form::select('created_by_id', ['' => __('Author')] + $users->pluck('name', 'id')->all(), null, ['class' =>"form-control mr-2", 'id' =>"created_by_id", 'name' =>"filter[created_by_id]"]) }}

{{ Form::select('assigned_to_id', ['' => __('Assigned To')] + $users->pluck('name', 'id')->all(), null, ['class' =>"form-control mr-2", 'id' =>"assigned_to_id", 'name' =>"filter[assigned_to_id]"]) }}

{{ Form::submit(__('Apply'), ['class' => "btn btn-primary mr-3"]) }}

{{ Form::close() }}
