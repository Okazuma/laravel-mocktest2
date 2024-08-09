@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-email.css') }}">
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
    <p class="email__title">お知らせメール</p>
    <form class="email__form" action="{{ route('management.email.send') }}" method="post">
        @csrf
        <p class="management__title">メール作成</p>
        <div class="form__item">
            <label class="form__title" for="subject">件名:</label>
            <input class="form__input" type="text" id="subject" name="subject">
            <div class="form__error">
                @error('subject')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form__item">
            <label class="form__title" for="content">内容:</label>
            <textarea class="form__text" id="content" name="content" rows="5"></textarea>
            <div class="form__error">
                @error('content')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form__item">
            <label class="form__title" for="users">ユーザー:</label>
            <select class="form__select" id="users" name="users[]" multiple>
                <option value="all">すべてのユーザー</option>
                @foreach(App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <div class="form__error">
                @error('users')
                {{ $message }}
                @enderror
            </div>
        </div>
        <button class="submit__button" type="submit">送信</button>
    </form>

    <div class="back__button">
        <a class="back__button__btn" href="/management/home">Back</a>
    </div>

</div>
@endsection

