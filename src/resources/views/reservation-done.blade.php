@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservation-done.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="done__text">ご予約ありがとうございます</p>
        <div class="back__button">
            <a class="back__button-btn" href="{{route('restaurants.index')}}">Home</a>
        </div>
    </div>
</div>
@endsection