@extends('layouts.dashboard')


@section('css')
<link rel="stylesheet" href="{{ asset('css/management/management-edit.css') }}">

@endsection
@section('content')
<div class="container">
  <p class="management-title">Create Restaurant</p>
  <form class="management__form" action="{{ route('management.success') }}" method="post" enctype="multipart/form-data">
  @csrf

  <div class="form__group">
    <P class="form-title">name</P>
    <input class="form-input" type="text" name="name" value="" placeholder="フルネーム">
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
@endsection
