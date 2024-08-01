<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    // 飲食店を予約する処理ーーーーーーーーーー
    public function store(ReservationRequest $request, Restaurant $restaurant)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '予約するにはログインが必要です。');
        }
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->restaurant_id = $restaurant->id;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->no_people = $request->no_people;
        $reservation->save();
        return redirect()->route('done');
    }


    // 予約完了ページの表示ーーーーーーーーーー
    public function done()
    {
        return view('done');
    }

}
