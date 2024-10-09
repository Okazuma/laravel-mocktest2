@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="session__alert">
    @if(session('message'))
    <div class="session__alert--success">
    {{ session('message') }}
    </div>
    @endif
</div>
<form action="{{ route('reviews.store', $restaurant->id) }}" method="post" enctype="multipart/form-data">
            @csrf
    <div class="container">
        <div class="restaurant">
            <p class="restaurant__title">今回のご利用はいかがでしたか？</p>
            <div class="card">
                <div class="card__image">
                    @if (config('filesystems.default') === 's3')
                        <img src="{{ $restaurant->image_path }}" alt="Restaurant Image">
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
        </div>
        <div class="center-line"></div>
        <div class="review__form">
            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
            <div class="form__group__rating">
                <p class="form__group__title">体験を評価してください</p>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ isset($userReview) && $userReview->rating == $i ? 'checked' : '' }} >
                        <label for="star{{ $i }}" class="star">&#9733;</label>
                    @endfor
                </div>
                <div class="form__error">
                    @error('rating')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__group__sub">口コミを投稿</p>
                <textarea class="form__text" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ $userReview->comment ?? old('comment') }}</textarea>
                <span class="form__group__memo">0/400 (最高文字数)</span>
                <div class="form__error">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div id="drop-area" class="drop-area">
                <input id="file-upload" type="file" name="review_image" value="" accept="image/*" hidden >
                <span class="drop-area__text">クリックして写真を追加<br>またはドラッグアンドドロップ</span>
                </div>
                @error('review_image')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <button class="submit__button" type="submit">口コミを投稿</button>
</form>


<script>
// ーーーーー５段階評価の処理ーーーーー
    const stars = document.querySelectorAll('.star-rating input');
    const labels = document.querySelectorAll('.star-rating label');
    const selectedRating = document.querySelector('.star-rating input:checked');
    if (selectedRating) {
        const selectedIndex = Array.from(stars).findIndex(star => star.checked);
        labels.forEach((label, i) => {
            label.style.color = (i <= selectedIndex) ? '#007BFF' : '#ccc';
        });
    }

    labels.forEach((label, index) => {
        label.addEventListener('mouseover', () => {
            // ホバーした星まで金色にする
            for (let i = 0; i <= index; i++) {
                labels[i].style.color = '#007BFF';
            }
        });
        label.addEventListener('mouseout', () => {
            // 選択された星の評価を保持
            const selectedRating = document.querySelector('.star-rating input:checked');
            if (!selectedRating) {
                labels.forEach((label) => {
                    label.style.color = '#ccc';
                });
            } else {
                // 選択された星まで金色にする
                const selectedIndex = Array.from(stars).findIndex(star => star.checked);
                labels.forEach((label, i) => {
                    label.style.color = (i <= selectedIndex) ? '#007BFF' : '#ccc';
                });
            }
        });
        label.addEventListener('click', () => {
            stars.forEach((star, i) => {
                if (i <= index) {
                    star.checked = true;
                }
            });
            labels.forEach((label, i) => {
                label.style.color = (i <= index) ? '#007BFF' : '#ccc';
            });
        });
    });


// ーーーーードラッグ&ドロップで画像添付の処理ーーーーー
    document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-upload');

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('highlight');
        });
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('highlight');
        });
        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('highlight');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files; // inputにファイルを設定
            dropArea.querySelector('p').textContent = files[0].name;
            }
        });
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });
        fileInput.addEventListener('change', (event) => {
            const files = event.target.files;
            if (files.length > 0) {
                dropArea.querySelector('p').textContent = files[0].name;
            }
        });
        dropArea.addEventListener('paste', (event) => {
            const items = (event.clipboardData || window.clipboardData).items;
            for (let index in items) {
                const item = items[index];
                if (item.kind === 'file') {
                    const file = item.getAsFile();
                    fileInput.files = [file];
                    dropArea.querySelector('p').textContent = file.name;
                }
            }
        });
    });


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
</script>
@endsection