<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Storage;


class ReviewController extends Controller
{
    // レビューページの表示ーーーーーーーーーー
    public function reviews($restaurant_id)
    {
        $userId = Auth::id();
        $restaurant = Restaurant::with('reviews')->findOrFail($restaurant_id);
        $userReview = Review::where('user_id', $userId)
                        ->where('restaurant_id', $restaurant_id)
                        ->first();

        return view('review',compact('restaurant','userReview'));
    }



    // レビュー投稿処理ーーーーーーーーーー
    public function storeReview(ReviewRequest $request, $restaurant_id)
    {
        $userId = Auth::id();
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('store_manager')) {
            return redirect()->back()->with('error', '口コミを投稿することができません。');
        }

        $existingReview = Review::where('user_id', $userId)
                                ->where('restaurant_id', $restaurant_id)
                                ->first();
        $fileName = $this->handleImageUpload($request, $existingReview);

        if ($existingReview) {
            $existingReview->delete();
        }

        $review = Review::create([
            'user_id' => $userId,
            'restaurant_id' => $restaurant_id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'review_image' => $fileName,
        ]);

        return redirect()->route('restaurants.detail', ['shop_id' => $restaurant_id]);
    }



    // レビュー画像アップロードの処理ーーーーーーーーーー
    private function handleImageUpload($request, $existingReview)
    {
        $fileName = null;

        if ($request->hasFile('review_image')) {
            if (config('filesystems.default') === 's3') {
                // S3に保存
                $filePath = $request->file('review_image')->store('review_images', 's3');
                $fileName = Storage::disk('s3')->url($filePath);
            } elseif (config('filesystems.default') === 'local') {
                // ローカルに保存
                $filePath = $request->file('review_image')->store('public/review_images');
                $fileName = 'storage/' . $filePath;
            } else {
                throw new \Exception('Unsupported filesystem configuration');
            }
        } else {
            // 画像が送信されていなければ既存の画像を保持
            $fileName = $existingReview ? $existingReview->review_image : null;
        }

        return $fileName;
    }



    // レビュー削除処理ーーーーーーーーーー
    public function deleteReview($id)
    {
        $userId = Auth::id();
        $review = Review::where('id', $id)
            ->when(!Auth::user()->hasRole('admin'), function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->firstOrFail();
        $review->delete();

        return redirect()->back()->with('message','レビューを削除しました');
    }



    // レビュー一覧ページの表示ーーーーーーーーーー
    public function reviewsAll($restaurant_id)
    {
        $restaurant = Restaurant::findOrFail($restaurant_id);
        $reviews = Review::where('restaurant_id', $restaurant_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('reviews-all', compact('restaurant', 'reviews'));
    }

}