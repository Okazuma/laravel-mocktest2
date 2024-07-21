@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
@endsection

@section('search')
<form class="search-form" id="search-form" action="{{route('restaurants.search')}}" method="GET">
    <div class="search__area-genre">
        <div class="search__area">
            <select name="area" id="area">
                <option value="">All area</option>
                <option value="東京都">東京都</option>
                <option value="大阪府">大阪府</option>
                <option value="福岡県">福岡県</option>
            </select>
        </div>
        <div class="search__genre">
            <select name="genre" id="genre">
                <option value="">All genre</option>
                <option value="寿司">寿司</option>
                <option value="焼肉">焼肉</option>
                <option value="居酒屋">居酒屋</option>
                <option value="イタリアン">イタリアン</option>
                <option value="ラーメン">ラーメン</option>
            </select>
        </div>
    </div>
    <div class="search__keyword">
        <label for="keyword"></label>
        <input type="text" name="keyword" id="keyword" placeholder="Search...">
    </div>
</form>
@endsection

@section('content')
<div class="container">
    @foreach($restaurants as $restaurant)
        <div class="card">
            <div class="card-image">
                <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
            </div>
            <div class="card-content">
                <h4 class="restaurant-name">{{ $restaurant->name }}</h4>
                <p class="restaurant-area-genre">#{{ $restaurant->area }}  #{{ $restaurant->genre }}</p>
                <div class="card-actions">
                    <a href="{{ route('restaurants.detail', $restaurant->id) }}" class="details-button">詳しく見る</a>

                    @auth
                        <button class="like-button" data-restaurant-id="{{ $restaurant->id }}">
                            <i class="fas fa-heart {{ Auth::user() && Auth::user()->likedRestaurants->contains($restaurant->id) ? 'liked' : '' }}"></i>
                        </button>
                    @else
                        <button class="like-button">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>



<!-- ーーーーーイイネボタン押下時の処理ーーーーー -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like-button');

        likeButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                @guest
                    alert('いいねを押すにはログインが必要です。');
                    return;
                @endguest

                const icon = this.querySelector('.fa-heart');
                const restaurantId = this.dataset.restaurantId;

                fetch(`/restaurants/${restaurantId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ restaurantId: restaurantId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        icon.classList.toggle('liked', data.liked);
                    } else {
                        console.error('いいね処理に失敗しました');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
<!-- ーーーーーイイネボタン押下時の処理ーーーーー -->



@yield('scripts')
<!-- ーーーーー検索フォーム使用時の処理ーーーーー -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const areaSelect = document.getElementById('area');
        const genreSelect = document.getElementById('genre');
        const keywordInput = document.getElementById('keyword');
        const searchForm = document.getElementById('search-form');

        // 初期値の設定
        const initialAreaValue = "{{ request()->input('area') }}";
        const initialGenreValue = "{{ request()->input('genre') }}";
        const initialKeywordValue = "{{ request()->input('keyword') }}";

        // 初期値を設定
        if (initialAreaValue) {
            areaSelect.value = initialAreaValue;
        }
        if (initialGenreValue) {
            genreSelect.value = initialGenreValue;
        }
        if (initialKeywordValue) {
            keywordInput.value = initialKeywordValue;
        }

        let debounceTimeoutArea;
    let debounceTimeoutGenre;
    let debounceTimeoutKeyword;

    function debounceSubmitArea() {
        clearTimeout(debounceTimeoutArea);
        debounceTimeoutArea = setTimeout(() => searchForm.submit(), 100);
    }

    function debounceSubmitGenre() {
        clearTimeout(debounceTimeoutGenre);
        debounceTimeoutGenre = setTimeout(() => searchForm.submit(), 100);
    }

    function debounceSubmitKeyword() {
        clearTimeout(debounceTimeoutKeyword);
        debounceTimeoutKeyword = setTimeout(() => searchForm.submit(), 1500);
    }

        areaSelect.addEventListener('change', debounceSubmitArea);
        genreSelect.addEventListener('change', debounceSubmitGenre);
        keywordInput.addEventListener('input', debounceSubmitKeyword);
    });
</script>
<!-- ーーーーー検索フォーム使用時の処理ーーーーー -->


@endsection
