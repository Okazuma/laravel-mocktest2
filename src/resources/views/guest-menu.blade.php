@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guest-menu.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">
            <a class="home__button" href="{{route('restaurants.index')}}">Home</a>
            <a class="register__button" href="{{route('register')}}">Registration</a>
            <a class="login__button" href="{{route('login')}}">Login</a>
    </div>
</div>
@endsection