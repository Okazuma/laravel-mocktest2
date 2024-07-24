<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Restaurant;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    // 管理者ページの表示ーーーーーーーーーー
    public function showAdminEdit()
    {
        $restaurants = Restaurant::all();

        return view('admin.admin-edit',compact('restaurants'));
    }



    // 店舗代表者作成の処理ーーーーーーーーーー
    public function storeRestaurantManager(AdminRequest $request)
    {
        $restaurantManagerRole = Role::where('name','restaurant_manager')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $restaurantManagerRole->id,
        ]);

        $user->managedRestaurant()->attach($request->restaurant_id);

        return redirect()->route('admin.admin-success');
    }

//     public function storeRestaurantManager(AdminRequest $request)
// {
//     $existingUser = $request->input('existing_user');
//     $email = $request->input('email');
//     $restaurantManagerRole = Role::where('name', 'restaurant_manager')->first();

//     if ($existingUser) {
//         // 既存ユーザーとして処理
//         $user = User::where('email', $email)->first();
//         if (!$user) {
//             return redirect()->back()->withErrors(['email' => '指定されたメールアドレスのユーザーが見つかりません。']);
//         }
//     } else {
//         // 新規ユーザーとして処理
//         $user = User::create([
//             'name' => $request->name,
//             'email' => $email,
//             'password' => Hash::make($request->password),
//             'role_id' => $restaurantManagerRole->id,
//         ]);
//     }

//     // 中間テーブルにレコードを追加
//     $user->managedRestaurants()->attach($request->restaurant_id);

//     return redirect()->route('admin.admin-success');
// }




// 店舗代表者作成完了ページの表示ーーーーーーーーーー
    public function adminSuccess()
    {
        return view('admin.admin-success');
    }

}
