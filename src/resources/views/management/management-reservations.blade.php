@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-reservations.css') }}">
@endsection
@section('content')


<div class="container">

    <p class="reservations__title">予約情報</p>

    <table class="reservations__table">
        <tr class="reservations__head">
            <th class="reservations__name">店舗名</th>
            <th class="reservations__date">予約日</th>
            <th class="reservations__time">予約時間</th>
            <th class="reservations__people">人数</th>
            <th class="reservations__user-name">お客様名</th>
        </tr>
        @foreach ($reservations as $reservation)
        <tr class="reservations__row">
            <td class="reservations__name">{{ $reservation->restaurant->name }}</td>
            <td class="reservations__date-white">{{ $reservation->date }}</td>
            <td class="reservations__time">{{ $reservation->time }}</td>
            <td class="reservations__people-white">{{ $reservation->no_people }}人</td>
            <td class="reservations__user-name">{{ $reservation->user->name }}</td>
        </tr>
        @endforeach
    <table>
    <div class="back__button">
        <a class="back__button-btn" href="/management/home" >Back</a>
    </div>

</div>

@endsection
