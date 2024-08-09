<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;

use SimpleSoftwareIO\QrCode\Facades\QrCode;


class MypageController extends Controller
{
    // マイページの表示ーーーーーーーーーー
    public function mypage()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->with('restaurant')->orderBy('date')->get();
        $likedRestaurants = $user->likedRestaurants;

        return view('mypage', compact('reservations', 'likedRestaurants'));
    }



    // 予約削除確認ページの表示
    public function confirm($id)
    {
        $reservation = Reservation::findOrFail($id);
        $restaurant = optional($reservation->restaurant);

        return view('delete-confirm', compact('reservation', 'restaurant'));
    }



    // 予約情報の削除ーーーーーーーーーー
    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();

        return redirect()->route('mypage');
    }



    // 予約情報の編集画面の表示ーーーーーーーーーー
    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $restaurant = optional($reservation->restaurant);

        return view('reservation-edit',compact('reservation','restaurant'));
    }



    // 予約情報の編集処理ーーーーーーーーーー
    public function update(ReservationRequest $request)
    {
        $reservation = $request->only('date','time','no_people');
        Reservation::find($request->id)->update($reservation);

        return redirect()->route('update');
    }

}
