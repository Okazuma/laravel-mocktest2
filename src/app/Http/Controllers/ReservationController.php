<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationController extends Controller
{
    // 飲食店を予約する処理ーーーーーーーーーー

    public function store(ReservationRequest $request, Restaurant $restaurant)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '予約するにはログインが必要です。');
        }   // ログインされていない場合はログインページにリダイレクト

        // 新しい予約を作成
        $reservation = new Reservation();
        $reservation->user_id = Auth::id(); // 現在認証されているユーザーのIDを取得
        $reservation->restaurant_id = $restaurant->id; // ルートモデルバインディングを利用して取得したレストランのID
        $reservation->date = $request->date; // リクエストから取得した日付
        $reservation->time = $request->time; // リクエストから取得した時間
        $reservation->no_people = $request->no_people; // リクエストから取得した人数
        $reservation->save(); // 予約をデータベースに保存

        return redirect('/done');
    }


    // マイページの表示ーーーーーーーーーー

    public function mypage()
    {
    $user = Auth::user();
    $reservations = $user->reservations()->with('restaurant')->orderBy('date')->get();
    $likedRestaurants = $user->likedRestaurants;

    return view('mypage', compact('reservations', 'likedRestaurants'));
    }


    // 予約情報の削除ーーーーーーーーーー

    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        // return redirect('mypage');
        return redirect()->route('mypage');
    }



    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $restaurant = optional($reservation->restaurant);

        $qrCode = QrCode::format('png')->size(300)->generate(route('reservation-edit', $id));
        // dd($qrCode);
        $base64QrCode = 'data:image/png;base64,' . base64_encode($qrCode);
// dd($base64QrCode);
        return view('reservation-edit',compact('reservation','restaurant', 'base64QrCode'));
    }

    
    public function update(ReservationRequest $request)
    {
        // dd($request->all());
        $reservation = $request->only('date','time','no_people');
        // unset($reservation['_token']);
        Reservation::find($request->id)->update($reservation);
        return redirect()->route('reservation-update');
    }


}
