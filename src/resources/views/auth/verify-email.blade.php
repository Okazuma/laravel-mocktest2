@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="session__alert">
    @if(session('message'))
    <div class="session__alert--success">
        {{ session('message') }}
    </div>
    @endif
</div>

<div class="container">
    <div class="card">
        <p class="card__text__head">会員登録ありがとうございます。</p>
            <p class="card__text__middle">確認メールを送りましたので、<br>本人確認を行なってください。</p>
        <div class="card-body">
            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif
            <p class="card__text__resend">確認メールが届いていない方</p>
            @if (session('email'))
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                <input type="hidden" name="email" value="{{ session('email') }}">
                    @csrf
                <button class="resend__button" type="submit">再送信</button>
            </form>
        </div>
    </div>
</div>

@else
<a href="{{ route('verification.resendAgain', ['email' => auth()->user()->email]) }}">認証メールを再送する</a>
@endif
@endsection