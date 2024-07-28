@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-home.css') }}">
</head>

@endsection
@section('content')

<div class="container">
    <div class="inner">
        <p class="title">Management</p>
        
        <div class="items">
        <a class="edit-btn" href="/management/edit" >作成と更新</a>
        <a class="reservation-btn" href="/management/reservations" >予約状況の確認</a>
        <a class="mail-btn" href="{{route('management.email.form')}}">案内メールの送信</a>
        </div>

    </div>

    <a class="back-btn" href="/">Back</a>
<form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="menu1__logout">
                <button class="button-logout" type="submit">Logout</button>
    </form>

</div>






@endsection

