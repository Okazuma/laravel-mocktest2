@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="session__alert">
    @if(session('message'))
        <div class="session__alert--success">
        {{ session('message') }}
        </div>
    @endif
</div>

<div class="container">
    <form class="review__form" action="/reviews" method="post">
        @csrf
        <p class="form__title">Review</p>
        <div class="form__group">
            <p class="form__group__title">ご利用店舗:</p>
            <select class="form__select" name="restaurant_id">
                <option value="" disabled selected>選択する</option>
                @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" >{{$restaurant->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form__group__rating">
            <p class="form__group__title">5段階で評価:</p>
            @for($i = 5; $i >= 1; $i--)
            <div class="form__group__item">
                <input class="form__radio" type="radio" id="rating{{$i}}" name="rating" value="{{$i}}" required/>
                <label class="rating__star" for="rating{{ $i }}">{{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}</label>
            </div>
            @endfor
        </div>
        <div class="form__group">
            <p class="form__group__title">コメント:</p>
            <textarea class="form__text" name="comment" cols="30" rows="5"></textarea>
        </div>
        <div class="form__group">
            <button class="submit__button" type="submit">送信</button>
        </div>
    </form>
    <div class="back__button">
        <a class="back__button-btn "href="{{ url('/') }}">HOME</a>
    </div>
</div>
@endsection
