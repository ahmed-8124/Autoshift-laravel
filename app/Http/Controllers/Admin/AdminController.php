<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total'    => Ad::count(),
            'pending'  => Ad::where('status', 'pending')->count(),
            'active'   => Ad::where('status', 'active')->count(),
            'users'    => User::count(),
        ];
        $recentAds = Ad::with(['make', 'user'])->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats', 'recentAds'));
    }
}
