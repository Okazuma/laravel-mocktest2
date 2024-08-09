<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    //
    public function openQrCode()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('store_manager')) {
                return redirect()->route('management.reservations');
            }
            return redirect()->route('restaurants.index');
        }
        return redirect()->route('login');
    }
}
