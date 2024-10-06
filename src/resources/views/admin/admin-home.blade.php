@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-home.css') }}">
@endsection

@section('content')
<div class="container">
    <p class="admin__title">Admin</p>
    <div class="admin__content">
        <a class="create-manager__button" href="{{route('admin.create-manager')}}" >店舗代表者の作成</a>
        <a class="import-csv__button" href="{{route('admin.import-csv')}}" >店舗情報の追加</a>
    </div>
    <div class="back__button">
        <a class="back__button__btn" href="/">Back</a>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout__button" type="submit">Logout</button>
    </form>
</div>
@endsection