@extends('layouts.app')

@section('content')
<main class="container py-4">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{__('Hello from Hexlet!')}}!</h1>
            <p class="lead">{{__('Practical programming courses')}}</p>
            <hr class="my-4">
            <a class="btn btn-primary btn-lg" href="https://hexlet.io" role="button">
                {{__('Learn more')}}
            </a>
        </div>
    </div>
</main>
@endsection
