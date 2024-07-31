@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">


@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="thanks-text">ご登録ありがとうございます</p>
        <a class="login-btn" href="/login">Login</a>
    </div>
</div>
@endsection