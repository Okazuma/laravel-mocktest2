@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-reservations.css') }}">
@endsection
@section('content')


<div class="container">

    <div class="reservations">
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
                <td class="reservations__date">{{ $reservation->date }}</td>
                <td class="reservations__time">{{ $reservation->time }}</td>
                <td class="reservations__people">{{ $reservation->no_people }}</td>
                <td class="reservations__user-name">{{ $reservation->user->name }}</td>
            </tr>
            @endforeach
        <table>
    </div>

    <a class="back-btn" href="/management/home" >Back</a>

</div>

@endsection
