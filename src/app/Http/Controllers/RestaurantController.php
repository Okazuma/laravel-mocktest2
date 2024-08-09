<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Auth;

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



    // 飲食店一覧ページの表示ーーーーーーーーーー
    public function detail(Request $request)
    {
        $shop_id = $request->route('shop_id');
        $restaurant = Restaurant::findOrFail($shop_id);

        return view('restaurant-detail', compact('restaurant'));
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

}
