@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-edit.css') }}">
@endsection
@section('content')

<div class="container">
    <p class="admin-title">Create Manager</p>
    <form class="admin__form" action="{{route('admin.admin-success')}}" method="post">
        @csrf
        <div class="form__group">
            <p class="admin__form-title">※飲食店の代表者名</p>
            <input class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="フルネーム" >
            <div class="form__error">
                @error('name')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form__group">
            <p class="admin__form-title">※メールアドレス</p>
            <input class="form-input" type="text" name="email" value="{{ old('email') }}" placeholder="メール形式">
            <div class="form__error">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>

        <div class="form__group">
            <p class="admin__form-title">※パスワード</p>
            <input class="form-input" type="password" name="password" value="" placeholder="8字以上">
            <div class="form__error">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>

        <div class="form__group">
        <p class="admin__form-title">※委任先の店舗</p>
        <select class="form-input" name="restaurant_id" id="restaurant" >
                <option value="">店舗を選択</option>

            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->name }}</option>
            @endforeach
        </select>
        <div class="form__error">
            @error('restaurant_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
            </div>
        </div>




        <button class="submit-btn" type="submit">送信</button>
    </form>
</div>

@endsection