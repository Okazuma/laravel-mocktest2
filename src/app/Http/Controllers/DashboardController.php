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
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.admin-edit');
        } elseif ($user->hasRole('store_manager')) {
            return redirect('/management/home');
        }
        return redirect('/');
    }

}
