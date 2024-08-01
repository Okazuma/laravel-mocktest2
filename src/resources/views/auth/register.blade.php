@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">
        <div class="card">
            <div class="card__heading">
                <p class="card__heading-ttl">Registration</p>
            </div>
            <form class="form" action="/register" method="post">
            @csrf
                <div class="form__content">
                    <div class="icon">
                        <i class="fa-solid fa-user custom-icon"></i>
                    </div>
                    <div class="form__input">
                        <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Username"/>
                    </div>
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__content">
                    <div class="icon">
                        <i class="fa-solid fa-envelope custom-icon"></i>
                    </div>
                    <div class="form__input">
                        <input type="text" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email"/>
                    </div>
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__content">
                    <div class="icon">
                        <i class="fa-solid fa-key custom-icon"></i>
                    </div>
                    <div class="form__input">
                        <input type="password" name="password" placeholder="Password"/>
                    </div>
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__content">
                    <button class="form__button-submit" type="submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
