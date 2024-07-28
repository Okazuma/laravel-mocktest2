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
        // $restaurant = Restaurant::findOrFail($restaurant_id);
        $restaurants = Restaurant::with('reviews')->get();

        // $reviews = Review::where('restaurant_id,$restaurantId')->get;

        return view('review',compact('restaurants'));
    }

    // public function storeReview(Request $request)
    // {
    //     $review = Review::create([
    //         $user_id => $request->user_id,
    //         $restaurant_id => $request->restaurant_id,
    //         $review => $request->review,
    //         $comment => $request->comment,
    //     ]);
    //     return redirect ('/reviews')->with('message','レビューを投稿しました');
    // }


    public function storeReview(Request $request)
    {
        $userId = Auth::id();
    $review = Review::create([
            'user_id' => $userId,
            'restaurant_id' => $request->input('restaurant_id'),
    'rating' => $request->input('rating'),
    'comment' => $request->input('comment'),
        ]);
        return redirect ('/reviews')->with('message','レビューを投稿しました');
}
}
