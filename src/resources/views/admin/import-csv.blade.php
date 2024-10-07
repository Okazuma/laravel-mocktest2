@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/import-csv.css') }}">
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <p class="admin__title">店舗情報の追加</p>
    <form class="admin__form" action="{{ route('restaurants.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <p class="admin__form__title">CSVファイルのインポート</p>
        <div class="custom-file-input">
            <label for="csv_file" class="custom-file-label">ファイルを選択</label>
            <input id="csv_file" class="form__input" type="file" name="csv_file" accept=".csv" hidden>
            <span class="file-name">選択されていません</span>
            @if ($errors->has('csv_file'))
                <div class="alert alert-danger error-message">
                    {{ $errors->first('csv_file') }}
                </div>
            @endif
        </div>
        <button class="submit__button" type="submit">インポート</button>
    </form>
    <div class="back__button">
        <a class="back__button__btn" href="{{route('admin.admin-home')}}">Back</a>
    </div>
</div>

<script>
    // ーーーーー添付ファイル表示の処理ーーーーー
    document.getElementById('csv_file').addEventListener('change', function() {
        var fileName = this.files.length > 0 ? this.files[0].name : '選択されていません';
        document.querySelector('.file-name').textContent = fileName;
    });
</script>
@endsection