@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/create-manager.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="alert alert--success">
{{ session('message') }}
</div>
@endif

<div class="container">
    <p class="admin__title">飲食店代表者の作成</p>
    <form class="admin__form" action="{{route('admin.store-manager')}}" method="post">
        @csrf
        <p class="admin__form__title">ユーザー情報</p>
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
        <a class="back__button__btn" href="{{route('admin.admin-home')}}">Back</a>
    </div>
</div>
@endsection