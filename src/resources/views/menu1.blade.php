@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu1.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

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
        </form>
    </div>
</div>

@endsection
