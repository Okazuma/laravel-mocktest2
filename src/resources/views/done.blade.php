@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">

@endsection

@section('content')
<div class="container">
    <div class="card">
        <p class="done-text">ご予約ありがとうございます</p>
        <a class="back-btn" href="/">戻る</a>
    </div>
</div>
@endsection