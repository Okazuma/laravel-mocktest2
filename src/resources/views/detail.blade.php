@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="restaurant__inner">
        <div class="restaurant__heading">
            <div class="back-button">
                <a class="back-button-back" href="{{route('restaurants.index')}}"><</a>
            </div>
            <h4 class="restaurant-name">{{ $restaurant->name }}</h4>
        </div>

        <div class="restaurant__image">
            <img src="{{ asset($restaurant->image_path) }}" class="restaurant__image-img" alt="{{ $restaurant->name }}">
        </div>

        <div class="restaurant__detail">
            <p class="restaurant-area">#{{ $restaurant->area }}</p>
            <p class="restaurant-genre">#{{ $restaurant->genre }}</p>
        </div>

        <p class="restaurant-description">{{ $restaurant->description }}</p>

    </div>








    <form class="reservation-form" action="{{ route('restaurants.reservation', $restaurant->id) }}" method="post">
        @csrf
<div class="reservation__inner">
        <p class="reservation__heading-ttl">予約</p>

        <div class="reservation__content">

            <div class="form-group">

            
                <div class="input-date">
                    <input type="date" class="form-control" id="date" name="date" >
                    <div class="form__error">
                    @error('date')
                    {{ $message }}
                    @enderror
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="input-time">
                    <select class="form-control" id="time" name="time">
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

            <div class="form-group">
                <div class="input-number">
                    <select class="form-control" id="number" name="no_people">
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
<button type="submit" class="reservation-submit">予約する</button>
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
