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
use App\Http\Requests\NoticeRequest;


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
        $data = $request->only(['name', 'description', 'area', 'genre']);
            if ($request->hasFile('image_path')) {
                if (config('filesystems.default') === 's3') {
                    $imagePath = $request->file('image_path')->store('images', 's3');
                    $data['image_path'] = Storage::disk('s3')->url($imagePath);
                } else {
                    $imagePath = $request->file('image_path')->store('public/images', 'local');
                    $data['image_path'] = 'images/' . basename($imagePath);
                }
            }

        $restaurant = Restaurant::create($data);

        return redirect()->route('management-edit')->with('message', '店舗情報を追加しました');
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
        $data = $request->only(['name', 'description', 'area', 'genre']);
        $disk = config('filesystems.default');

        if ($request->hasFile('image')) {
            // 既存の画像を削除
            if ($restaurant->image_path) {
                if ($disk === 's3') {
                    // S3の場合
                    Storage::disk('s3')->delete(str_replace('https://s3.amazonaws.com/laravel-mocktest-bucket2/', '', $restaurant->image_path));
                } else {
                    // localの場合
                    Storage::disk('local')->delete('public/' . str_replace('images/', '', $restaurant->image_path));
                }
            }

            if ($disk === 's3') {
                $imagePath = $request->file('image')->store('images', 's3');
                $data['image_path'] = Storage::disk('s3')->url($imagePath);
            } else {
                $imagePath = $request->file('image')->store('public/images', 'local');
                $data['image_path'] = 'images/' . basename($imagePath);
            }
        }
        $restaurant->update($data);

        return redirect()->route('management.update', ['id' => $id])
                        ->with('message', '店舗情報を更新しました');
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
    public function sendEmail(NoticeRequest $request)
    {
        $users = $request->input('users');
        $subject = $request->input('subject');
        $content = $request->input('content');
            if (in_array('all', $users)) {
                $users = User::all();
            } else {
                $users = User::whereIn('id', $users)->get();
            }
            foreach ($users as $user) {
                Mail::to($user->email)->send(new UserNotification($subject, $content));
            }
        return redirect()->route('management.email.form')->with('message', 'お知らせメールを送信しました');
    }
}