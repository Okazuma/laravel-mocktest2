@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reviews-all.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="reviews__header">
        <div class="back__button">
                <a class="back__button-back" href="{{ route('restaurants.detail', $restaurant->id) }}"><</a>
        </div>

        <h4 class="restaurant__name">{{ $restaurant->name }} の口コミ一覧</h4>
    </div>

    @if ($reviews->isEmpty())
        <p>この店舗にはまだ口コミがありません。</p>
    @else
        @foreach ($reviews as $review)
            <div class="review__item">

                <div class="review__header">
                    <span class="review--user">{{ $review->user->name }}</span>
                    @if(Auth::check())
                        <div class="review__button">
                            <!-- 編集ボタン: ログインユーザーがレビューを投稿した場合のみ表示 -->
                            @if(Auth::id() == $review->user_id)
                            <div class="review__button--edit">
                                <a href="{{ route('reviews', ['restaurant_id' => $restaurant->id]) }}" class="review__button--edit-btn">口コミを編集</a>
                                </div>
                            @endif
                            <!-- 削除ボタン: ログインユーザーがレビュー投稿者 または 管理者の場合に表示 -->
                            @if(Auth::id() == $review->user_id || Auth::user()->hasRole('admin'))
                            <form class="review__button--delete" action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button class="review__button--delete-btn" type="submit">口コミを削除</button>
                            </form>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="star-rating">
                    <span class="star-rating--number">評価: {{ $review->rating }}/5</span>
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">
                            @if ($i <= $review->rating)
                                &#9733; <!-- Filled star -->
                            @else
                                &#9734; <!-- Empty star -->
                            @endif
                        </span>
                    @endfor
                </div>


                <div class="review__content">
                    @if ($review->review_image)
                    <div class="review__image">
                        @if (config('filesystems.default') === 's3')
                            <img src="{{ $review->review_image }}" alt="Restaurant Image">
                        @else
                            <img src="{{ asset('storage/' . $review->review_image) }}" alt="口コミ画像">
                        @endif
                    </div>
                    @endif
                    <span class="review__text">{{ $review->comment }}</span>
                </div>

            </div>
        @endforeach
    @endif
</div>
@endsection