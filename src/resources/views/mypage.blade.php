@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="heading">
        <div class="space"></div>
        <p class="likes__whose">{{Auth::user()->name}}さん</p>
    </div>
    <div class="content">
        <div class="reservation">
            <div class="reservation__title">
                <p class="reservation__title__ttl">予約状況</p>
            </div>
            @foreach($reservations as $index => $reservation)
            <div class="reservation__content">
                <div class="reservation__items">
                    <div class="reservation__time" >
                        <a class="reservation__edit" href="{{ route('edit', ['id' => $reservation->id]) }}">
                        <i class="fa-solid fa-clock"></i></a>
                        <span class="reservation__number">予約{{ $index + 1 }}</span>
                    </div>
                    <a class="delete__button__btn" href="{{ route('confirm', $reservation->id) }}" ><i class="fa-solid fa-x"></i></a>
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
                <p class="likes__title__ttl">お気に入り店舗</p>
            </div>
            <div class="likes__inner">
                @foreach($likedRestaurants as $restaurant)
                <div class="likes__card">
                    <div class="likes__card__image">
                        @if (config('filesystems.default') === 's3')
                            <img src="{{ $restaurant->image_path }}" alt="Restaurant Image">
                        @else
                            <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
                        @endif
                    </div>
                    <div class="likes__card__content">
                        <h3 class="likes__restaurant__name">{{ $restaurant->name }}</h3>
                        <p class="likes__restaurant__area__genre">#{{ $restaurant->area }}  #{{ $restaurant->genre }}</p>
                        <div class="likes__card__actions">
                            <a href="{{ route('restaurants.detail', $restaurant->id) }}" class="likes__details__button">詳しく見る</a>
                            @auth
                                <button class="like__button" data-restaurant-id="{{ $restaurant->id }}">
                                    <i class="fas fa-heart {{ Auth::user() && Auth::user()->likedRestaurants->contains($restaurant->id) ? 'liked' : '' }}"></i>
                                </button>
                            @else
                                <button class="like__button">
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



<script>
// ーーーーーいいね機能の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like__button');

        likeButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                @guest
                    alert('いいねを押すにはログインが必要です。');
                    return;
                @endguest

                const icon = this.querySelector('.fa-heart');
                const restaurantId = this.dataset.restaurantId;

                fetch(`/restaurants/${restaurantId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ restaurantId: restaurantId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        icon.classList.toggle('liked', data.liked);
                    } else {
                        console.error('いいね処理に失敗しました');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endsection
