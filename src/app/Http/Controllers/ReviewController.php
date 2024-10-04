<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;


class ReviewController extends Controller
{
    // レビューページの表示ーーーーーーーーーー
    public function reviews($restaurant_id)
    {
        $userId = Auth::id();
        $restaurant = Restaurant::with('reviews')->findOrFail($restaurant_id);


        // ユーザーの口コミを取得
        $userReview = Review::where('user_id', $userId)
                        ->where('restaurant_id', $restaurant_id)
                        ->first(); // ユーザーが投稿した最初の口コミを取得

        return view('review',compact('restaurant','userReview'));
    }



    // レビュー投稿処理ーーーーーーーーーー
    // public function storeReview(ReviewRequest $request,$restaurant_id)
    // {
    //     $userId = Auth::id();
    //     $fileName = null;
        
    //     // 既存の口コミがある場合、削除する
    //     $existingReview = Review::where('user_id', $userId)
    //                             ->where('restaurant_id', $restaurant_id)
    //                             ->first();

    //     if ($existingReview) {
    //         $existingReview->delete(); // 古い口コミを削除
    //     }

    //     // 新しい画像を保存
    //     if ($request->hasFile('review_image')) {
    //         $filePath = $request->file('review_image')->store('review_images', config('filesystems.default'));
    //         if (config('filesystems.default') === 's3') {
    //             $fileName = Storage::disk('s3')->url($filePath);
    //         } else {
    //             $fileName = $filePath;
    //         }
    //     }

    //     // 新しい口コミを作成
    //     $review = Review::create([
    //         'user_id' => $userId,
    //         'restaurant_id' => $restaurant_id,
    //         'rating' => $request->input('rating'),
    //         'comment' => $request->input('comment'),
    //         'review_image' => $fileName,
    //     ]);

    //     return redirect()->route('restaurants.detail', ['shop_id' => $restaurant_id])
    //                     ->with('message','レビューを投稿しました。');
    // }



    // レビュー投稿処理
public function storeReview(ReviewRequest $request, $restaurant_id)
{
    $userId = Auth::id();
    $fileName = null;

    // 既存の口コミがある場合、削除する
    $existingReview = Review::where('user_id', $userId)
                            ->where('restaurant_id', $restaurant_id)
                            ->first();

    if ($existingReview) {
        // 画像が送信されている場合、新しい画像を保存
        if ($request->hasFile('review_image')) {
            $filePath = $request->file('review_image')->store('review_images', config('filesystems.default'));
            if (config('filesystems.default') === 's3') {
                $fileName = Storage::disk('s3')->url($filePath);
            } else {
                $fileName = $filePath;
            }
        } else {
            // 画像が送信されていない場合、既存の画像を保持
            $fileName = $existingReview->review_image;
        }

        // 古い口コミを削除
        $existingReview->delete();
    }

    // 新しい口コミを作成
    $review = Review::create([
        'user_id' => $userId,
        'restaurant_id' => $restaurant_id,
        'rating' => $request->input('rating'),
        'comment' => $request->input('comment'),
        'review_image' => $fileName, // 既存の画像か新しい画像を使用
    ]);

    return redirect()->route('restaurants.detail', ['shop_id' => $restaurant_id])
                    ->with('message','レビューを投稿しました。');
}



    public function deleteReview($id)
    {
        $userId = Auth::id();
        $review = Review::where('id', $id)
            ->when(!Auth::user()->hasRole('admin'), function ($query) use ($userId) {
                // 管理者以外の場合は、自分のレビューのみを対象にする
                return $query->where('user_id', $userId);
            })
            ->firstOrFail();

        $review->delete();

        return redirect()->back()->with('message','レビューを削除しました');
    }



    public function reviewsAll($restaurant_id)
    {
        // 該当するレストランを取得
        $restaurant = Restaurant::findOrFail($restaurant_id);

        // 該当するレストランに対する全ての口コミを取得
        $reviews = Review::where('restaurant_id', $restaurant_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // ビューにデータを渡して表示
        return view('reviews-all', compact('restaurant', 'reviews'));
    }

}
