@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guest-menu.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">

        <div class="menu__button">
            <a class="home__button" href="{{route('restaurants.index')}}">Home</a>
        </div>

        <div class="menu__button">
            <a class="register__button" href="{{route('register')}}">Registration</a>
        </div>

        <div class="menu__button">
            <a class="login__button" href="{{route('login')}}">Login</a>
            <a class="login__button" href="{{route('login')}}">login</a>
        </div>

    </div>
</div>
@endsection