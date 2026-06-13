<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('ads')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
}
