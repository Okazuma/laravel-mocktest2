@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

@endsection

@section('content')

<div class="container">
    <div class="inner">

        <div class="card">
            <div class="content">
                <p class="text">ご予約ありがとうございます</p>
    
                <div class="back">
                    <a class="back__button" href="/">戻る</a>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection
