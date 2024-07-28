@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
        <form class="review__form" action="/reviews" method="post">
            @csrf
            <select class="" name="restaurant_id">
                <option></option>
                @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" >{{$restaurant->name}}</option>
                @endforeach
            </select>
            <div class="rating">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" id="rating{{$i}}" name="rating" value=""{{$i}} required/>
                <label for="rating{{ $i }}">{{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}</label>
                @endfor
            </div>
            <div class="rating">
                <textarea type="text" name="name" cols="30" rows="5"value=""></textarea>
            </div>
            <button class="" type="submit">送信</button>
        </form>

<div class="review__content">
</div>
<table class="">

    <tr>
        <th>店舗名</th>
        <th>評価</th>
        <th>コメント</th>
</tr>

@foreach($restaurant->reviews as $review)
    <tr>
        <td>{{$restaurant->name}}</td>
        <td>{{$review->rating}}</td>
        <td>{{$review->comment}}</td>
</tr>
@endforeach

</div>

@endsection
