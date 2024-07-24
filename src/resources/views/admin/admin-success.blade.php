@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-success.css') }}">
@endsection
@section('content')

<div class="container">
    <p class="success-text">Created Manager!!</p>

<a class="back-btn" href="{{route('admin.admin-edit')}}">Back</a>

</div>


@endsection