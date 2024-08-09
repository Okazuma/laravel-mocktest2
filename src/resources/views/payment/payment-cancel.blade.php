@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment/payment-cancel.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">
        <h1 class="cancel__title">Payment Canceled!</h1>
        <p class="cancel__text">決済が中断されました。<br>再度決済をやり直してください。</p>
    </div>
    <div class="cancel__items">
        <a class="checkout__button" href="/checkout">決済へ</a>
        <a class="back__button" href="{{ url('/') }}">Home</a>
    </div>
</div>
@endsection