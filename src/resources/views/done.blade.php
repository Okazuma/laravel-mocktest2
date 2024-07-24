@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="done-text">ご予約ありがとうございます</p>
        <a class="back-btn" href="/">戻る</a>
    </div>
</div>
@endsection