@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu2.css') }}">
@endsection

@section('content')


<div class="container">
    <div class="inner">
        <div class="menu1__button">
            <a class="button-home" href="/">Home</a>
        </div>
        
            <div class="menu1__button">
                <a class="button-registration" href="/register">Registration</a>
            </div>
            <div class="menu1__button">
                <a class="button-mypage" href="{{route('login')}}">Login</a>
            </div>
        
    </div>
</div>


@endsection