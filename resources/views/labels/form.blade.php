{{ Form::label('name', __('Name')) }}
{{ Form::text('name', $label->name ?? null, ['class' => 'form-control my-2']) }}
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
{{ Form::label('description', __('Description')) }}
{{ Form::textarea('description', $label->description ?? null, ['class' => 'form-control my-2', 'cols' => '50', 'rows' => '10']) }}
@error('description')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
