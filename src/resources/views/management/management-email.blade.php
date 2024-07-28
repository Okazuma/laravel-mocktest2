@extends('layouts.backend')


@section('css')
<link rel="stylesheet" href="{{ asset('css/management/management-email.css') }}">

@endsection

@section('content')

    <div>
        @if (session('message'))
        <p>{{ session('message') }}</p>
        @endif
    </div>
<div class="container">
    <form class="email__form" action="{{ route('management.email.send') }}" method="post">
        @csrf
        <div class="form__item">
            <label class="form__title" for="subject">件名:</label>
            <input class="form-input" type="text" id="subject" name="subject" required>
        </div>
        <div class="form__item">
            <label class="form__title" for="content">内容:</label>
            <textarea class="form-text" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form__item">
            <label class="form__title" for="users">ユーザー:</label>
            <select class="form-select" id="users" name="users[]" multiple required>
                @foreach(App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="submit-btn" type="submit">送信</button>
    </form>

    <a class="back-btn" href="/management/home">Back</a>

</div>
@endsection

