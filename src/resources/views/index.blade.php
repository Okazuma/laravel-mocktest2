@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('sort')
<form class="sort__form" id="sort-form" action="{{ route('restaurants.sort') }}" method="GET">
    <select class="sort__select" name="sort" id="sort">
        <option value="" disabled {{ request('sort') ? '' : 'selected' }}>並び替え: 評価高/低</option>
        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>評価が高い順</option>
        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>評価が低い順</option>
        <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
    </select>
</form>
@endsection

@section('search')
<form class="search__form" id="search-form" action="{{route('restaurants.search')}}" method="GET">
    <div class="search__area__genre">
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
            <div class="card__image">
                @if (config('filesystems.default') === 's3')
                    <img src="{{ Storage::url($restaurant->image_path) }}" alt="Restaurant Image">
                @else
                    <img src="{{ asset($restaurant->image_path) }}" alt="{{ $restaurant->name }}のイメージ">
                @endif
            </div>
            <div class="card__content">
                <p class="restaurant__name">{{ $restaurant->name }}</p>
                <span class="restaurant__area__genre">#{{ $restaurant->area }}  #{{ $restaurant->genre }}</span>
                <div class="card__actions">
                    <a  class="details__button" href="{{ route('restaurants.detail', $restaurant->id) }}" class="details__button">詳しく見る</a>
                    @auth
                        <button class="like__button" data-restaurant-id="{{ $restaurant->id }}">
                            <i class="fas fa-heart {{ Auth::user() && Auth::user()->likedRestaurants->contains($restaurant->id) ? 'liked' : '' }}"></i>
                        </button>
                    @else
                        <button class="like__button">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>



<script>
// ーーーーーいいね機能の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like__button');

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

// ーーーーーソート機能の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sort');
        const sortForm = document.getElementById('sort-form');
        function submitSortForm() {
            sortForm.submit();
        }
        sortSelect.addEventListener('change', submitSortForm);
    });

// ーーーーー並び替えボタンの文字調整処理ーーーーー
    function adjustOptionText() {
        const sortOption = document.querySelector('option[disabled]');
        if (window.innerWidth <= 576) {
            sortOption.textContent = '並び';
        } else if (window.innerWidth <= 768) {
            sortOption.textContent = '並び替え';
        } else {
            sortOption.textContent = '並び替え: 評価高/低';
        }
    }
    window.addEventListener('load', adjustOptionText);
    window.addEventListener('resize', adjustOptionText);
</script>

@yield('scripts')
<script>
// ーーーーー検索フォーム使用時の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function() {
        const areaSelect = document.getElementById('area');
        const genreSelect = document.getElementById('genre');
        const keywordInput = document.getElementById('keyword');
        const searchForm = document.getElementById('search-form');
        const initialAreaValue = "{{ request()->input('area') }}";
        const initialGenreValue = "{{ request()->input('genre') }}";
        const initialKeywordValue = "{{ request()->input('keyword') }}";

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
@endsection