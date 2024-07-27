<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{

    // ログインフォームの表示ーーーーー

    public function showLoginForm()
    {
        return view('auth.login');
    }


    // ログイン処理ーーーーー

    // public function login(LoginRequest $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();

    //         if($user->hasRole('admin')){
    //             return redirect()->intended('/admin/edit');//  認証済みなら'/admin/edit'へ
    //         }elseif($user->hasRole('store_manager')){
    //             return redirect()->intended('/management/home');
    //         }else{
    //             return redirect()->intended('/');//  認証済みなら'/'へ
    //     }
    //     } else {
    //         return redirect('/login');
    //     }
    // }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
                return redirect()->intended('/');//  認証済みなら'/'へ
        }else{
            return redirect('/login');
        }
    }


    // ログアウト処理ーーーーー

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}

