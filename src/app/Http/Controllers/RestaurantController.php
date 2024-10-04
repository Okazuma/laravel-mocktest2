<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    // 飲食店一覧ページの表示ーーーーーーーーーー
    public function index()
    {
        $restaurants = Restaurant::all();

        return view('index',compact('restaurants'));
    }



    // ログインユーザーメニューの表示ーーーーーーーーーー
    public function menuUser()
    {
        return view('user-menu');
    }



    // ゲストユーザーメニューの表示ーーーーーーーーーー
    public function menuGuest()
    {
        return view('guest-menu');
    }



    // 検索フォームの処理ーーーーーーーーーー
    public function search(Request $request)
    {
        $query = Restaurant::query();

            if ($request->filled('area')) {
                $query->where('area', $request->input('area'));
            }
            if ($request->filled('genre')) {
                $query->where('genre', $request->input('genre'));
            }
            if ($request->filled('keyword')) {
                $keyword = $request->input('keyword');
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        $restaurants = $query->get();

        return view('index', compact('restaurants'));
    }



    // 飲食店詳細ページの表示ーーーーーーーーーー
    public function detail(Request $request)
    {
        $shop_id = $request->route('shop_id');
        $restaurant = Restaurant::findOrFail($shop_id);
        $userId = Auth::id();
        $userReview = null;  // 未ログインユーザーに対しては null を設定
        // ユーザーの口コミを取得
        if ($userId) {
        $userReview = Review::where('restaurant_id', $shop_id)
                            ->where('user_id', $userId)
                            ->first();
        }

        return view('restaurant-detail', compact('restaurant','userReview'));
    }


    // いいね機能の処理ーーーーーーーーーー
    public function like(Restaurant $restaurant)
    {
        $user = Auth::user();
        if ($user->likedRestaurants->contains($restaurant->id)) {
            $user->likedRestaurants()->detach($restaurant->id);
            $liked = false;
        } else {
            $user->likedRestaurants()->attach($restaurant->id);
            $liked = true;
        }
        return response()->json(['success' => true, 'liked' => $liked]);
    }



// public function sort(Request $request)
// {
//     $sortOrder = $request->input('sort', 'desc'); // デフォルトで降順

//     $restaurants = Restaurant::with('reviews')
//         ->withAvg('reviews', 'rating') // reviewsテーブルのratingの平均値を取得
//         ->orderBy('reviews_avg_rating', $sortOrder) // 取得した平均値でソート
//         ->get();

//     return view('index', compact('restaurants'));
// }


public function sort(Request $request)
{
    $sortOrder = $request->input('sort', 'desc'); // デフォルトは評価が高い順（降順）

    $query = Restaurant::with('reviews');

    // ソートの条件に応じたクエリの分岐
    if ($sortOrder === 'random') {
        // ランダムで並べ替え
        $query->inRandomOrder();
    } else {
        // 評価の高い順または低い順で並べ替え
        $query->withAvg('reviews', 'rating')
              ->orderBy('reviews_avg_rating', $sortOrder);
    }

    $restaurants = $query->get();

    return view('index', compact('restaurants'));
}




}
