@extends('layouts.app')

@section('h1')
    {{ __('Labels') }}
@endsection

@section('content')
    @if (Auth::user())
    <a href="{{ route('labels.create')}}" class="btn btn-primary">
        {{ __('Create label') }}
    </a>
    @endif
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{__('Created at')}}</th>
                @if (Auth::user())
                <th>{{ __('Actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ date('d.m.Y', strtotime($label->created_at)) }}</td>
                <td>
                    @if (Auth::user())
                        <a class="text-danger" href="{{ route('labels.destroy', $label->id)}}" data-confirm="{{ __('Аre you sure?') }}" data-method="delete" rel="nofollow">
                            {{ __('Delete') }}
                        </a>
                        <a href="{{ route('labels.edit', $label->id) }}">
                            {{ __('Edit') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="navigation">
        {{ $labels->links("pagination::bootstrap-4") }}
    </nav>
@endsection
