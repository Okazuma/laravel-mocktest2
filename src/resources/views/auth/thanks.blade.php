@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="thanks__text">メールアドレスの確認ができました。<br>ご登録ありがとうございます</p>
        <a class="login__button" href="/login">Login</a>
    </div>
</div>
@endsection