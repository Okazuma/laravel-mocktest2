<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Http\Requests\ManagementRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotification;
use App\Models\User;


class ManagementController extends Controller
{
// 飲食店代表者のHOMEの表示ーーーーーーーーーー

    public function showManagementHome()
    {
        return view('management.management-home');
    }


// 飲食店代表者の編集ページの表示ーーーーーーーーーー

    public function showManagementEdit()
    {
        $restaurants = Restaurant::all();
        return view('management.management-edit',compact('restaurants'));
    }



// 飲食店作成の処理ーーーーーーーーーー

    public function storeRestaurant(ManagementRequest $request)
    {
        $imagePath = $request->file('image')->store('public/images');
        $imagePath = str_replace('public/', 'storage/', $imagePath);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'description' => $request->description,
            'area' => $request->area,
            'genre' => $request->genre,
            'image_path' => $imagePath,
        ]);
        return redirect()->route('management-edit')->with('message','店舗が追加されました');
    }



// 飲食店の編集画面の表示ーーーーーーーーーー

    public function showManagementUpdate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('management.management-update', compact('restaurant'));
    }



// 飲食店の編集の処理ーーーーーーーーーー

    public function updateRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        // 更新するデータを取得
        $data = $request->only(['name', 'description', 'area', 'genre']);
        // 店舗情報の更新
        $restaurant->update($data);
        // 更新成功後のリダイレクト
        return redirect()->route('management.edit', ['id' => $id])
                        ->with('success', '店舗情報が更新されました。');
    }



    // 予約確認ページの表示ーーーーーーーーーー

    public function showManagementReservations()
    {
        $reservations = Reservation::with('user')->get();
        return view('management.management-reservations',compact('reservations'));
    }



    // お知らせメール送信画面の表示ーーーーーーーーーー

    public function showEmailForm()
    {
        return view('management.management-email');
    }



    // お知らせメール送信の処理ーーーーーーーーーー

    public function sendEmail(Request $request)
    {
        $users = User::whereIn('id',$request->input('users'))->get();
        $subject = $request->input('subject');
        $content = $request->input('content');

        foreach($users as $user){
            Mail::to($user->email)->send(new UserNotification($subject, $content));
        }
        return redirect()->route('management.email.form')->with('message','メールが送信されました');
    }

}
