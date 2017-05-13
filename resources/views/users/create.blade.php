@extends('layout.defalut')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            This is the home page of Learn Laravel
        </p>
        <p>
            Everything start from here!
        </p>
        <p>
            <!-- ע�ᰴť-->
            <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Sign up now !</a>
        </p>
    </div>


@stop