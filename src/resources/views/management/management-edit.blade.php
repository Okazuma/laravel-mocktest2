@extends('layouts.backend')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/management/management-edit.css') }}">
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
  <p class="edit__title">店舗情報の管理</p>
  <div class="edit__content">
    <div class="create">
      <p class="management__title">飲食店情報の作成</p>
      <form class="management__form" action="{{ route('management-edit') }}" method="post" enctype="multipart/form-data">
      @csrf
        <div class="form__group">
          <P class="form__title">name:</P>
          <input class="form__input" type="text" name="name" value="" placeholder="店舗名">
            @error('name')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form__group">
          <P class="form__title">image_path:</P>
          <input class="form__input" type="file" name="image" value="">
              @error('image_path')
              <span class="error-message">{{$message}}</span>
              @enderror
        </div>
        <div class="form__group">
          <P class="form__title">area:</P>
          <input class="form__input" type="text" name="area" value="" placeholder="エリア">
            @error('area')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form__group">
          <P class="form__title">genre:</P>
          <input class="form__input" type="text" name="genre" value="" placeholder="ジャンル">
            @error('genre')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form__group">
          <P class="form__title">description:</P>
          <textarea class="form__input" type="text" name="description" value="" placeholder="店舗の紹介文"  cols="30" rows="5"></textarea>
            @error('description')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <button class="submit__button" type="submit">送信</button>
      </form>
    </div>

    <div class="detail">
      <p class="management__title">飲食店情報の編集</p>
      @foreach($restaurants as $restaurant)
      <div class="detail__content">
        <p class="restaurant__name">{{$restaurant->name}}</p>
          <div class="restaurant__detail">
            <a class="restaurant__detail__button" href="{{route('management.restaurants',$restaurant->id)}}">詳細</a>
          </div>
        </div>
      @endforeach
      </div>
    </div>
  <div class="back__button">
    <a class="back__button__btn" href="/management/home" >Back</a>
  </div>

</div>
@endsection