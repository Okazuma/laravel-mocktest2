@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qrcode.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

@endsection

@section('content')
<div class="container">
<p class="text">スタッフへご提示ください！</p>
    <div class="qr-code">
        <img src="{{ $base64QrCode }}" class="qr-code-image" alt="QR Code">
    </div>
    <a class="back-btn" href="/mypage">戻る</a>




</div>



@endsection

