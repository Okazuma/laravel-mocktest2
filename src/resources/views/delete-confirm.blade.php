@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="container">
    <form class="confirm__form" action="/delete/{{ $reservation->id }}" method="post">
        @method('delete')
        @csrf
        <div class="inner">
            <p class="confirm__form__title">※予約の削除</p>
            <div class="confirm__content">
                <input type="hidden" name="id" value="{{ $reservation->id }}">
                <table class="confirm__table">
                    <tr class="confirm__row">
                        <th class="confirm__title">Shop</th>
                        <td class="confirm__detail">{{$restaurant->name}}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Date</th>
                        <td class="confirm__detail">{{$reservation->date}}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Time</th>
                        <td class="confirm__detail">{{$reservation->time}}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Number</th>
                        <td class="confirm__detail">{{$reservation->no_people}}人</td>
                    </tr>
                </table>
            </div>
        </div>
        <button class="delete__button" type="submit" class="reservation-submit">予約を削除する</button>
    </form>
</div>
@endsection
