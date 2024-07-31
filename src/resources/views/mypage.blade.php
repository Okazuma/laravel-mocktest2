@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection

@section('content')

<div class="container">
    <div class="heading">
        <div class="space"></div>
        <p class="likes-whose">{{Auth::user()->name}}さん</p>
    </div>

    <div class="content">

        <div class="reservation">
            <div class="reservation__title">
                <p class="reservation__title-ttl">予約状況</p>
            </div>

            @foreach($reservations as $index => $reservation)
            <div class="reservation__content">
                <div class="reservation__items">
                    <div class="reservation-time" >
                        <a class="reservation-edit" href="{{ route('edit', ['id' => $reservation->id]) }}">
                        <i class="fa-solid fa-clock"></i>
                        </a>
                        <a class="reservation-number" href="{{ route('show.qrcode', $reservation->id) }}">予約{{ $index + 1 }}</a>
                    </div>
                    <form class="delete__button" action="/delete/{{ $reservation->id }}" method="post">
                    @method('delete')
                    @csrf
                        <button class="delete__button-btn" type="submit" ><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>

                <div class="reservation__detail">
                    <table class="reservation__table">
                        <tr class="reservation__row">
                            <th class="reservation__head">Shop</th>
                            <td class="reservation__desc">{{ $reservation->restaurant->name }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <th class="reservation__head">Date</th>
                            <td class="reservation__desc">{{ $reservation->date }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <th class="reservation__head">Time</th>
                            <td class="reservation__desc">{{ $reservation->time }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <th class="reservation__head">Number</th>
                            <td class="reservation__desc">{{ $reservation->no_people }}人</td>
                        </tr>
                    </table>
                </div>

            </div>
            @endforeach
        </div>



        <div class="likes">
            <div class="likes__title">
                <p class="likes__title-ttl">お気に入り店舗</p>
            </div>

            <div class="likes__inner">
                @foreach($likedRestaurants as $restaurant)
                <div class="likes__card">
                    <div class="likes__card-image">
                        <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
                    </div>
                    <div class="likes__card-content">
                        <h4 class="likes__restaurant-name">{{ $restaurant->name }}</h4>
                        <p class="likes__restaurant-area-genre">#{{ $restaurant->area }}  #{{ $restaurant->genre }}</p>
                        <div class="likes__card-actions">
                            <a href="{{ route('restaurants.detail', $restaurant->id) }}" class="likes__details-button">詳しく見る</a>
                            @auth
                                <button class="like-button" data-restaurant-id="{{ $restaurant->id }}">
                                    <i class="fas fa-heart {{ Auth::user() && Auth::user()->likedRestaurants->contains($restaurant->id) ? 'liked' : '' }}"></i>
                                </button>
                            @else
                                <button class="like-button">
                                    <i class="fas fa-heart"></i>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
