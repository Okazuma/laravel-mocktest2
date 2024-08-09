@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/management/management-success.css') }}">
@endsection

@section('content')
<div class="container">
    <p class="success__text">Created Restaurant!!</p>
    <a class="back__button" href="/management/edit" >Back</a>
</div>
@endsection