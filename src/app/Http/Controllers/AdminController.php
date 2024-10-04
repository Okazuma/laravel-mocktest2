<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Restaurant;
use App\Http\Requests\AdminRequest;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }


    // 管理者ページの表示ーーーーーーーーーー
    public function showAdminEdit()
    {
        $restaurants = Restaurant::all();

        return view('admin.admin-edit',compact('restaurants'));
    }



    // 店舗代表者作成の処理ーーーーーーーーーー
    public function storeRestaurantManager(AdminRequest $request)
    {
        $storeManagerRole = Role::where('name','store_manager')->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
        ]);
        $user -> assignRole('store_manager');

        return redirect()->route('admin.admin-create')->with('message','managerを作成しました');
    }



    // 店舗代表者作成完了ページの表示ーーーーーーーーーー
    public function adminSuccess()
    {
        return view('admin.admin-success');
    }

}