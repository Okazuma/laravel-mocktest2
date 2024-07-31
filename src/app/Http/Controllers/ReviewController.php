<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    //
    public function reviews()
    {
        $restaurants = Restaurant::with('reviews')->get();
        return view('review',compact('restaurants'));
    }


    public function storeReview(Request $request)
    {
        $userId = Auth::id();
        $review = Review::create([
            'user_id' => $userId,
            'restaurant_id' => $request->input('restaurant_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);
        return redirect ('/reviews')->with('message','レビューを投稿しました。');
    }
}
