<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    // ログインフォームの表示ーーーーーーーーーー
    public function showLoginForm()
    {
        return view('auth.login');
    }


    // ログイン処理ーーーーーーーーーー
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
                return redirect()->intended('/');
        }else{
            return redirect('/login');
        }
    }


}

