@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-home.css') }}">
</head>
@endsection
@section('content')

<div class="container">
    <p class="management__title">Management</p>
    <div class="management__content">
        <a class="edit__button" href="/management/edit" >作成と更新</a>
        <a class="reservation__button" href="{{route('management.reservations')}}" >予約状況の確認</a>
        <a class="mail__button" href="{{route('management.email.form')}}">案内メールの送信</a>
    </div>

    <div class="back__button">
        <a class="back__button-btn" href="/">Back</a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout__button" type="submit">Logout</button>
    </form>

</div>

@endsection

