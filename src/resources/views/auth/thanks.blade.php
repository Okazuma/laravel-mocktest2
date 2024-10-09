@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="thanks__text">メール認証を完了しました。<br>ご登録ありがとうございます！</p>
        <div class="login__button">
            <a class="login__button-btn" href="{{route('login')}}">Login</a>
        </div>
    </div>
</div>
@endsection