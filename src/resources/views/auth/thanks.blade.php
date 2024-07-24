@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="thanks-text">ご登録ありがとうございます</p>
        <a class="login-btn" href="/login">Login</a>
    </div>
</div>
@endsection