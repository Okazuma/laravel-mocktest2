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
        $userRole = Role::where('name','user')->first();  //ロールを取得

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($userRole);  //ロールを付与

        event(new Registered($user));  //登録時に認証メールを送信
        session(['email' => $user->email]);  //登録するメールアドレスを保持

        return view('auth.verify-email');
        // return redirect()->route('verification.notice');
    }


    public function thanks()
    {
        return view('auth.thanks');
    }

    // 会員登録後の認証要求ページの表示ーーーーーーーーーー

    // public function show()
    // {
    //     return view('auth.verify-email');
    // }


    // 認証メールの再送信ーーーーー

    // public function resendVerificationEmail(Request $request)
    // {
    //     $email = $request->query('email');

    //     $user = User::where('email', $email)->first();
    //     $user->sendEmailVerificationNotification();

    //     // return redirect('email/verify/resend');
    //     return back()->with('message', '認証リンクを再送しました。');
    // }

}




