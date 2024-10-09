@extends('layouts.app')<!DOCTYPE html>

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment/payment-success.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="inner">
        <h1 class="success__title">Payment Successful!</h1>
        <p class="success__text">決済が完了しました。<br>ありがとうございます！</p>
    </div>
    <div class="back__button">
            <a class="back__button-btn" href="{{route('restaurants.index')}}">Home</a>
        </div>
</div>
@endsection