@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/restaurant-detail.css') }}">
@endsection
<div class="session__alert">
    @if(session('message'))
    <div class="session__alert--success">
    {{ session('message') }}
    </div>
    @endif
</div>
@section('content')
<div class="container">
    <div class="restaurant__inner {{ isset($userReview) ? 'shortened' : '' }}" >
        <div class="restaurant__heading">
            <div class="back__button">
                <a class="back__button-back" href="{{route('restaurants.index')}}"><</a>
            </div>
            <h4 class="restaurant__name">{{ $restaurant->name }}</h4>
        </div>
        <div class="restaurant__image">
            @if (config('filesystems.default') === 's3')
                <img src="{{ $restaurant->image_path }}" alt="Restaurant Image">
            @else
                <img src="{{ asset('/' . $restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
            @endif
        </div>
        <div class="restaurant__detail">
            <p class="restaurant__area">#{{ $restaurant->area }}</p>
            <p class="restaurant__genre">#{{ $restaurant->genre }}</p>
        </div>
        <p class="restaurant__description">{{ $restaurant->description }}</p>



        <div class="review">
        <!-- 口コミの表示 -->
        @if (Auth::check())
        <!-- 管理者または一般ユーザーがログインしている場合 -->
            @if($userReview || Auth::user()->hasRole('admin'))
            <!-- 「全ての口コミ情報」ボタン -->
            <div class="reviews--all">
            <a class="reviews--all__button" href="{{ route('reviews.all', ['restaurant_id' => $restaurant->id]) }}">全ての口コミ情報</a>
            </div>
            @endif
            @if($userReview)
                <div class="user__review">
                    <div class="review__button">
                        <a class="review__button--edit-btn" href="{{ route('reviews', ['restaurant_id' => $restaurant->id]) }}">口コミを編集</a>
                        <form class="review__button--delete" action="{{ route('reviews.destroy', $userReview->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button class="review__button--delete-btn" type="submit">口コミを削除</button>
                        </form>
                    </div>

                    <div class="form__group__rating">
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $userReview->rating ? 'filled' : '' }}">
                                    @if ($i <= $userReview->rating)
                                        &#9733; <!-- Filled star -->
                                    @else
                                        &#9734; <!-- Empty star -->
                                    @endif
                                </span>
                            @endfor
                        </div>
                        <p class="review--comment">{{ $userReview->comment }}</p>
                    </div>
                </div>
            @else
                <a class="review__comment--first" href="{{ route('reviews', ['restaurant_id' => $restaurant->id]) }}">口コミを投稿する</a>
            @endif
        @endif
        </div>
    </div>

    <form class="reservation__form" action="{{ route('restaurants.reservation', $restaurant->id) }}" method="post">
        @csrf
        <div class="reservation__inner">
            <p class="reservation__heading__ttl">予約</p>

            <div class="reservation__content">
                <div class="form__group">
                    <div class="input__date">
                        <input type="date" class="form__control" id="date" name="date" >
                        <div class="form__error">
                        @error('date')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="input__time">
                        <select class="form__control" id="time" name="time">
                            <option value="" selected>予約時間</option>
                                @php
                                $startTime = strtotime('17:00');
                                $endTime = strtotime('23:00');
                                $interval = 30 * 60; // 30分
                                for ($time = $startTime; $time <= $endTime; $time += $interval) {
                                    $formattedTime = date('H:i', $time);
                                    echo "<option value='$formattedTime'>$formattedTime</option>";
                                }
                                @endphp
                        </select>
                        <div class="form__error">
                        @error('time')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="input__number">
                        <select class="form__control" id="number" name="no_people">
                            <option value="" selected>人数</option>
                            <option value="1">1人</option>
                            <option value="2">2人</option>
                            <option value="3">3人</option>
                            <option value="4">4人</option>
                            <option value="5">5人</option>
                        </select>
                        <div class="form__error">
                        @error('no_people')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </div>
                <table class="confirm__table">
                    <tr class="confirm__row">
                        <th class="confirm__title">Shop</th>
                        <td class="confirm__detail">{{ $restaurant->name }}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Date</th>
                        <td class="confirm__detail"><span id="display-date"></span></td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Time</th>
                        <td class="confirm__detail"><span id="display-time"></span></td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__title">Number</th>
                        <td class="confirm__detail"><span id="display-number"></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <button type="submit" class="submit__button">予約する</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const numberInput = document.getElementById('number');

        dateInput.addEventListener('input', function () {
            document.getElementById('display-date').textContent = dateInput.value;
        });

        timeInput.addEventListener('input', function () {
            document.getElementById('display-time').textContent = timeInput.value;
        });

        numberInput.addEventListener('change', function () {
            const numberValue = numberInput.options[numberInput.selectedIndex].text;
            document.getElementById('display-number').textContent = numberValue;
        });
    });
</script>
@endsection