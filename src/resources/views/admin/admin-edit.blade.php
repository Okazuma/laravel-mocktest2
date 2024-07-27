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


    <p class="admin-title">管理者画面</p>
    <form class="admin__form" action="{{route('admin.admin-edit')}}" method="post">
        @csrf
        <div class="form__group">
            <p class="admin__form-title">※飲食店の代表者名</p>
            <input class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="フルネーム" >
            <div class="form__error">
                @error('name')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form__group">
            <p class="admin__form-title">※メールアドレス</p>
            <input class="form-input" type="text" name="email" value="{{ old('email') }}" placeholder="メール形式">
            <div class="form__error">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>

        <div class="form__group">
            <p class="admin__form-title">※パスワード</p>
            <input class="form-input" type="password" name="password" value="" placeholder="8字以上">
            <div class="form__error">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>

        




        <button class="submit-btn" type="submit">送信</button>
    </form>

    <a class="back-btn" href="/">Back</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="button-logout" type="submit">Logout</button>
    </form>

</div>

@endsection