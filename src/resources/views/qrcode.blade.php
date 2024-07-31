@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qrcode.css') }}">
@endsection

@section('content')

<div class="container">
    <p class="text">スタッフへご提示ください！</p>
    <div class="qr-code">
        <img src="{{ $base64QrCode }}" class="qr-code-image" alt="QR Code">
        <a href="/checkout">支払い</a>
    </div>
    <a class="back-btn" href="/mypage">戻る</a>
</div>

@endsection

