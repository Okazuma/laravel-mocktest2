@extends('layouts.backend')


@section('css')
<link rel="stylesheet" href="{{ asset('css/management/management-edit.css') }}">

@endsection
@section('content')
<div class="todo__alert">
    @if(session('message'))
      <div class="todo__alert--success">
      {{ session('message') }}
      </div>
    @endif
  </div>

  <a class="back-btn" href="/management/home" >Back</a>

<div class="container">

  <div class="create">
    <p class="management-title">飲食店情報の作成</p>
    <form class="management__form" action="{{ route('management-edit') }}" method="post" enctype="multipart/form-data">
    @csrf

      <div class="form__group">
        <P class="form-title">name</P>
        <input class="form-input" type="text" name="name" value="" placeholder="店舗名">
        <div class="error">
          @error('name')
          <span class="error-message">{{$message}}</span>
          @enderror
        </div>
      </div>


      <div class="form__group">
        <P class="form-title">description</P>
        <input class="form-input" type="text" name="description" value="" placeholder="店舗の説明文">
        <div class="error">
          @error('description')
          <span class="error-message">{{$message}}</span>
          @enderror
        </div>
      </div>


      <div class="form__group">
        <P class="form-title">area</P>
        <input class="form-input" type="text" name="area" value="" placeholder="エリア">
        <div class="error">
          @error('area')
          <span class="error-message">{{$message}}</span>
          @enderror
        </div>
      </div>


      <div class="form__group">
        <P class="form-title">genre</P>
        <input class="form-input" type="text" name="genre" value="" placeholder="ジャンル">
        <div class="error">
          @error('genre')
          <span class="error-message">{{$message}}</span>
          @enderror
        </div>
      </div>


      <div class="form__group">
        <P class="form-title">image_path</P>
        <input class="form-input" type="file" name="image" value="">
        <div class="form__error">
            @error('image_path')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
      </div>


      <button class="submit-btn" type="submit">送信</button>

    </form>
  </div>

  <div class="detail">
    <p class="management-title">飲食店情報の編集</p>

    @foreach($restaurants as $restaurant)
    <div class="detail__content">
    
      <p class="restaurant-name">{{$restaurant->name}}</p>
        <div class="restaurant-detail">
          <a class="restaurant-detail-btn" href="{{route('management.restaurants',$restaurant->id)}}">詳細</a>
         </div>
        
    </div>
    @endforeach
  </div>


  


</div>

@endsection