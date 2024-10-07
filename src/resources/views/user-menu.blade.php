@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-menu.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">
        <div class="menu__button">
            <a class="home__button" href="/">Home</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="menu__logout">
                <button class="logout__button" type="submit">Logout</button>
            </div>
            <div class="menu__button">
                <a class="mypage__button" href="/mypage">Mypage</a>
            </div>
            @can('view-dashboard')
            <div class="menu__button">
                <a class="dashboard__button" href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            @endcan
        </form>
    </div>
</div>
@endsection