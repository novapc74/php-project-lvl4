{{ Form::label('name', __('Name')) }}
{{ Form::text('name', old('$label->name'), ['class' => 'form-control my-2']) }}
@includeIf('inc.error', ['status' => 'name'])

{{ Form::label('description', __('Description')) }}
{{ Form::textarea('description', old('$label->description'), ['class' => 'form-control my-2', 'cols' => '50', 'rows' => '10']) }}
@includeIf('inc.error', ['status' => 'description'])
