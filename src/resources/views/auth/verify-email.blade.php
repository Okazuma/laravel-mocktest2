@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="session__alert">
    @if(session('success'))
    <div class="session__alert--success">
        {{ session('success') }}
    </div>
    @endif
</div>

<div class="container">
    @if (session('registered'))
    <div class="card">
        <p class="card__text">会員登録ありがとうございます。<br>確認メールを送りましたので、<br>本人確認を行なってください。</p>

        <p class="card__text__resend">---確認メールが届いていない方---</p>

        <form class="resend__form" method="POST" action="{{ route('verification.resend') }}">
        @csrf
            <div class="form__group">
                <label class="form__label" for="email">登録したメールアドレスを入力</label>
                <input class="form__input" type="text" name="email" >
            </div>
            @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror
            @if ($errors->has('verify_error'))
                <div class="error-message">
                    {{ $errors->first('verify_error') }}
                </div>
            @endif

            <button class="resend__button" type="submit">再送信</button>
        </form>
    </div>






    @elseif (session('resend'))
        <div class="card">
            <p class="card__text">メール認証がされていません。<br>確認メールを再度送信して<br>本人確認を行なってください。</p>
            <form class="resend__form" method="POST" action="{{ route('verification.resend') }}">
            @csrf
                <div class="form__group">
                    <label class="form__label" for="email">登録したメールアドレスを入力</label>
                    <input class="form__input" type="text" name="email" >
                </div>
                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
                @if ($errors->has('verify_error'))
                    <div class="error-message">
                        {{ $errors->first('verify_error') }}
                    </div>
                @endif
                <button class="resend__button" type="submit">再送信</button>
            </form>
        </div>




    @else
        <div class="card">
            <p class="card__text">メール認証がされていません。<br>確認メールを再度送信して<br>本人確認を行なってください。</p>
            <form class="resend__form" method="POST" action="{{ route('verification.resend') }}">
            @csrf
                <div class="form__group">
                    <label class="form__label" for="email">登録したメールアドレスを入力</label>
                    <input class="form__input" type="text" name="email" >
                    @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
                @if ($errors->has('verify_error'))
                    <div class="error-message">
                        {{ $errors->first('verify_error') }}
                    </div>
                @endif
                </div>

            <button class="resend__button" type="submit">再送信</button>
            </form>
        </div>
    @endif
</div>


@endsection