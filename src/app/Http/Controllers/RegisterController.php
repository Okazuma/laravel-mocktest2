<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    //会員登録ページの表示ーーーーーーーーーー
    public function showRegisterForm()
    {
        return view('auth.register');
    }



    //会員登録の処理ーーーーーーーーーー
    public function register(RegisterRequest $request)
    {
        $userRole = Role::where('name','user')->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($userRole);

        event(new Registered($user));
        session(['email' => $user->email]);

        return view('auth.verify-email');
    }



    // メール認証後のページの表示
    public function thanks()
    {
        return view('auth.thanks');
    }

}




