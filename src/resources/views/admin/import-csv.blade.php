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
                <div class="alert alert-danger error-message">{{ $errors->first('csv_file') }}</div>
            @endif
            @if ($errors->has('csv_import'))
                <div class="alert alert-danger error-message">
                    <p>エラーが{{ count($errors->get('csv_import')) }} 件発生しました</p>
                    @foreach ($errors->get('csv_import') as $index => $error)
                        @if ($index < 1)
                            <p>{!! $error !!}</p>
                        @endif
                    @endforeach
                    @if (count($errors->get('csv_import')) > 1)
                        <div id="error-details" style="display:none;">
                            @foreach ($errors->get('csv_import') as $index => $error)
                                @if ($index >= 1)
                                    <p>{!! $error !!}</p>
                                @endif
                            @endforeach
                        </div>
                        <button id="toggle-error-details" class="error-details__button" onclick="toggleErrorDetails()">他のエラーを表示</button>
                    @endif
                </div>
            @endif
        </div>
        <button class="submit__button" type="submit">インポート</button>
    </form>

    <form class="admin__form" action="{{ route('images.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <p class="admin__form__title">画像のアップロード</p>
        <div class="custom-file-input">
            <label for="images" class="custom-file-label">画像を選択 (複数選択可)</label>
            <input id="images" class="form__input" type="file" name="images[]" accept="image/*" multiple hidden>
            <span class="image-name">選択されていません</span>
            @if ($errors->has('images'))
                <div class="alert alert-danger error-message">{{ $errors->first('images') }}</div>
            @endif
        </div>
        <button class="submit__button" type="submit">アップロード</button>
    </form>

    <div class="back__button">
        <a class="back__button__btn" href="{{route('admin.admin-home')}}">Back</a>
    </div>
</div>



<script>
// ーーーーーcsv添付ファイル表示の処理ーーーーー
    document.getElementById('csv_file').addEventListener('change', function() {
        var fileName = this.files.length > 0 ? this.files[0].name : '選択されていません';
        document.querySelector('.file-name').textContent = fileName;
    });


    // ーーーーー画像ファイル表示の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function () {
        const inputFile = document.getElementById('images');
        const imageNameLabel = document.querySelector('.image-name');

        inputFile.addEventListener('change', function () {
            const files = Array.from(inputFile.files);
            if (files.length > 0) {
                const fileNames = files.map(file => file.name).join(', ');
                imageNameLabel.textContent = fileNames;
            } else {
                imageNameLabel.textContent = '添付されていません';
            }
        });
    });


// ーーーーーエラーの開閉処理ーーーーー
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('toggle-error-details');
        var errorDetails = document.getElementById('error-details');

        if (toggleButton) {
            toggleButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (errorDetails.style.display === "none") {
                    errorDetails.style.display = "block"; // 詳細を表示
                    toggleButton.textContent = "他のエラーを隠す";
                } else {
                    errorDetails.style.display = "none";
                    toggleButton.textContent = "他のエラーを表示";
                }
            });
        }
    });
</script>
@endsection