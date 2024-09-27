@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-update.css') }}">
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
    <div class="restaurant--current">
        <p class="update__title">現在の店舗情報</p>
        <p class="restaurant__name">店舗名:{{ $restaurant->name }}</p>
        <div class="restaurant__image">
            @if (config('filesystems.default') === 's3')
                <img src="{{ Storage::disk('s3')->url($restaurant->image_path) }}" alt="No image">
            @else
                <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
            @endif
        </div>
        <div class="restaurant__detail">
            <div class="restaurant__detail__item">
                <span class="restaurant__detail__title">エリア:</span>
                <p class="restaurant-area">#{{ $restaurant->area }}</p>
            </div>
            <div class="restaurant__detail__item">
                <span class="restaurant__detail__title">ジャンル:</span>
                <p class="restaurant-genre">#{{ $restaurant->genre }}</p>
            </div>
        </div>
        <p class="restaurant__description">{{ $restaurant->description }}</p>
    </div>

    <form class="restaurant--new" action="{{ route('management.update', $restaurant->id) }}" method="post" enctype="multipart/form-data">
    @method('patch')
    @csrf
        <p class="update__title">新しい店舗情報</p>
        <div class="new__item">
            <label class="new__title" for="name-subject">店舗名:</label>
            <input class="new__name" id="name-subject" type="text" name="name" placeholder="店舗名" value="{{$restaurant->name}}" placeholder="店舗名" required>
        </div>
        <div class="new__item">
            <label class="new__title" for="image">イメージ画像:</label>
            <input class="new__image" type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="new__item">
            <label class="new__title" for="area-subject">エリア:</label>
            <input  class="new__area" id="area-subject" type="text" name="area" value="{{$restaurant->area}}" placeholder="エリア" required>
        </div>
        <div class="new__item">
            <label class="new__title" for="genre-subject">ジャンル:</label>
            <input  class="new__genre" id="genre-subject" type="text" name="genre" value="{{$restaurant->genre}}" placeholder="ジャンル" required>
        </div>
        <div class="new__item">
            <label class="new__title" for="desc-subject">店舗紹介文:</label>
            <textarea  class="new__desc" id="desc-subject" name="description" cols="30" rows="5" placeholder="店舗紹介文">{{$restaurant->description}}</textarea>
        </div>
        <div class="new__item">
            <button class="update__button" type="submit">更新</button>
        </div>
    </form>
</div>
<div class="back__button">
    <a class="back__button__btn" href="/management/edit" >Back</a>
</div>
@endsection