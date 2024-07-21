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

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/'); //  認証済みなら'/'へ遷移する
        } else {
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

