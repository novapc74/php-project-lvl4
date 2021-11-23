{{ Form::label('name', __('Name')) }}
{{ Form::text('name', old('$taskStatus->name'), ['class' => 'form-control my-2']) }}
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
