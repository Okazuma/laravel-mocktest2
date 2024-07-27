@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-update.css') }}">

@endsection
@section('content')
<a class="back-btn" href="/management/edit" >Back</a>
<div class="container">

    <div class="before">
        <div class="card-image">
            <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
            </div>
        <p class="success-text">{{$restaurant->name}}</p>
        <p class="success-text">{{$restaurant->description}}</p>
        <p class="success-text">{{$restaurant->area}}</p>
        <p class="success-text">{{$restaurant->genre}}</p>
    </div>


    <form class="after" action="{{ route('management.update', $restaurant->id) }}" method="post">
        @method('patch')
        @csrf
        <input type="text" name="name" placeholder="店舗名" value="{{$restaurant->name}}" placeholder="店舗名" required>
        <textarea name="description" cols="30" rows="5" placeholder="店舗紹介文">{{$restaurant->description}}</textarea>
        <input type="text" name="area" value="{{$restaurant->area}}" placeholder="エリア" required>
        <input type="text" name="genre" value="{{$restaurant->genre}}" placeholder="ジャンル" required>

        <button type="submit">送信</button>
    </form>



</div>

@endsection