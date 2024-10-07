<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResendVerificationEmailRequest;

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


    public function notice()
    {
        return view('auth.verify-email');
    }




    // 認証メールの再送信ーーーーーーーーーー
    public function resendVerificationEmail(ResendVerificationEmailRequest $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->back()->withErrors(['verify_error' => 'このメールアドレスは既に認証されています。']);
        }

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('success', '認証メールを再送しました。')->with('resend', true);
    }

}