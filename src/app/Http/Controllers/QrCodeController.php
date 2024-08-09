<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    //QRコードにアクセスしたときの処理ーーーーーーーーーー
        public function openQrCode(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('store_manager')) {
                return redirect()->route('management.reservations');
            }
            return redirect()->route('restaurants.index');
        }
        Session::put('intended_url', route('qr-code.open'));
        return redirect()->route('login');
    }
}
