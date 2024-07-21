@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

@endsection

@section('content')



<div class="container">
    <div class="inner">

        <div class="card">
            <div class="card__heading">
                <p class="card__heading-ttl">Login</p>
            </div>

            <form class="form" action="/login" method="post">
            @csrf

                <div class="form__content">
                    <div class="icon">
                        <i class="fa-solid fa-envelope custom-icon"></i>
                    </div>
                    <div class="form__input">
                        <input type="text" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email"/>
                    </div>
                    <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                    </div>
                </div>

                <div class="form__content">
                    <div class="icon">
                        <i class="fa-solid fa-key custom-icon"></i>
                    </div>
                    <div class="form__input">
                        <input type="password" name="password" placeholder="Password"/>
                    </div>
                    <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                    </div>
                </div>

                <div class="form__content">
                    <button class="form__button-submit" type="submit">ログイン</button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
