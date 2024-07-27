<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('can:view-dashboard');
    }
    public function showDashboard()
    {
        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザーの役割に応じてリダイレクト先を決定
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.admin-edit');
        } elseif ($user->hasRole('store_manager')) {
            return redirect('/management/home');
        }
        return redirect('/');
    }

}
