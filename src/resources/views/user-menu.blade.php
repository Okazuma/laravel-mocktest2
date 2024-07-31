@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu1.css') }}">


@endsection

@section('content')
<div class="container">
    <div class="inner">
        <div class="menu1__button">
            <a class="button-home" href="/">Home</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="menu1__logout">
                <button class="button-logout" type="submit">Logout</button>
            </div>
            <div class="menu1__button">
                <a class="button-mypage" href="/mypage">Mypage</a>
            </div>

            @can('view-dashboard')
            <div class="menu1__button">
                <a class="button-dashboard" href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            @endcan
        </form>
    </div>
</div>

@endsection
