@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-edit.css') }}">
@endsection

@section('content')
<div class="todo__alert">
        @if(session('message'))
        <div class="todo__alert--success">
        {{ session('message') }}
        </div>
        @endif
    </div>

<div class="container">
    <p class="admin__title">Admin</p>
    <form class="admin__form" action="{{route('admin.admin-edit')}}" method="post">
        @csrf
        <p class="admin__form__title">飲食店情報の作成</p>
        <div class="form__group">
            <p class="form__group__title">※飲食店の代表者名</p>
            <input class="form__input" type="text" name="name" value="{{ old('name') }}" placeholder="フルネーム" >
            <div class="form__error">
                @error('name')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <p class="form__group__title">※メールアドレス</p>
            <input class="form__input" type="text" name="email" value="{{ old('email') }}" placeholder="メール形式" >
            <div class="form__error">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="form__group">
            <p class="form__group__title">※パスワード</p>
            <input class="form__input" type="password" name="password" value="" placeholder="8字以上">
            <div class="form__error">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <button class="submit__button" type="submit">作成</button>
    </form>
    <div class="back__button">
        <a class="back__button__btn" href="/">Back</a>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout__button" type="submit">Logout</button>
    </form>
</div>
@endsection