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
        }   // ログインされていない場合はログインページにリダイレクト

        // 新しい予約を作成
        $reservation = new Reservation();
        $reservation->user_id = Auth::id(); // 現在認証されているユーザーのIDを取得
        $reservation->restaurant_id = $restaurant->id; // ルートモデルバインディングを利用して取得したレストランのID
        $reservation->date = $request->date; // リクエストから取得した日付
        $reservation->time = $request->time; // リクエストから取得した時間
        $reservation->no_people = $request->no_people; // リクエストから取得した人数
        $reservation->save(); // 予約をデータベースに保存

        return redirect()->route('done');
    }



//     public function store(Request $request, Restaurant $restaurant)
// {

//     // 予約情報を作成
//     $reservation = Reservation::create([
//         'user_id' => Auth::id(), // 現在認証されているユーザーのIDを取得
//         'restaurant_id' => $request->restaurant_id, // リクエストから取得したレストランのID
//         'date' => $request->date, // リクエストから取得した日付
//         'time' => $request->time, // リクエストから取得した時間
//         'no_people' => $request->no_people, // リクエストから取得した人数
//     ]);

//     // 成功メッセージと共にリダイレクト
//     return redirect()->route('done');
// }



    // 予約完了ページの表示ーーーーーーーーーー
    public function done()
    {
        return view('done');
    }


    

}
