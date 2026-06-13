<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Dashboard') — AutoShift Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
</head>
<body>
<div class="admin-wrap">

    {{-- Sidebar --}}
    <aside class="admin-side">
        <div class="admin-brand">⚡ Auto<span>Shift</span></div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.ads') }}" class="{{ request()->routeIs('admin.ads*') ? 'active' : '' }}">
            <i class="fas fa-car"></i> Manage Ads
        </a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.makes') }}" class="{{ request()->routeIs('admin.makes*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i> Makes
        </a>
        <a href="{{ route('home') }}" style="margin-top:16px;border-top:1px solid rgba(255,255,255,.1);padding-top:16px;">
            <i class="fas fa-store"></i> View Site
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;width:100%;text-align:left;padding:13px 20px;color:rgba(255,255,255,.75);cursor:pointer;font-size:14px;display:flex;align-items:center;gap:10px;font-family:inherit;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </aside>

    {{-- Main --}}
    <main class="admin-main">
        @if(session('success'))
            <div class="flash-msg flash-success" style="border-radius:7px;margin-bottom:18px;padding:12px 16px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-msg flash-error" style="border-radius:7px;margin-bottom:18px;padding:12px 16px;">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
