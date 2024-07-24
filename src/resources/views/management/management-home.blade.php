@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-home.css') }}">
</head>

@endsection
@section('content')

<div class="container">
    <p class="management-title">Management Home</p>
    <a class="edit-btn" href="/management/edit" >To Edit</a>
    <a class="reservation-btn" href="/management/reservations" >To Reservations</a>
</div>




@endsection

