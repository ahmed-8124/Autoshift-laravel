<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AutoShift') — Pakistan's Vehicle Marketplace</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>

{{-- Top Strip --}}
<div class="topstrip">
    <div class="container topstrip-inner">
        <span><i class="fas fa-map-marker-alt"></i> Pakistan's #1 Used Vehicle Marketplace</span>
        <div class="topstrip-right">
            @auth
                <span>Hi, {{ auth()->user()->name }}</span>
                <a href="{{ route('user.my-ads') }}">My Ads</a>
                <a href="{{ route('favorites') }}"><i class="fas fa-heart"></i></a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.75);cursor:pointer;font-size:13px;padding:0;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</div>

{{-- Header --}}
<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-icon">⚡</span>
            <span class="logo-text">Auto<span>Shift</span></span>
        </a>

        <nav class="mainnav">
            <div class="nav-item dropdown">
                <a href="{{ route('ads.search', ['type'=>'car']) }}" class="nav-link">
                    <i class="fas fa-car"></i> Cars <i class="fas fa-chevron-down fa-xs"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('ads.search', ['type'=>'car']) }}">All Cars</a>
                    <a href="{{ route('ads.search', ['type'=>'car','condition'=>'New']) }}">New Cars</a>
                    <a href="{{ route('ads.search', ['type'=>'car','condition'=>'Used']) }}">Used Cars</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ route('ads.search', ['type'=>'bike']) }}" class="nav-link">
                    <i class="fas fa-motorcycle"></i> Bikes <i class="fas fa-chevron-down fa-xs"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('ads.search', ['type'=>'bike']) }}">All Bikes</a>
                    <a href="{{ route('ads.search', ['type'=>'bike','condition'=>'New']) }}">New Bikes</a>
                    <a href="{{ route('ads.search', ['type'=>'bike','condition'=>'Used']) }}">Used Bikes</a>
                </div>
            </div>
            <a href="{{ route('ads.search') }}" class="nav-link"><i class="fas fa-search"></i> Browse All</a>
        </nav>

        <a href="{{ route('ads.create') }}" class="btn-post">
            <i class="fas fa-plus"></i> Post Ad <span class="free-tag">FREE</span>
        </a>
    </div>
</header>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-msg flash-success"><div class="container">{{ session('success') }}</div></div>
@endif
@if(session('error'))
    <div class="flash-msg flash-error"><div class="container">{{ session('error') }}</div></div>
@endif
@if($errors->any())
    <div class="flash-msg flash-error">
        <div class="container">
            @foreach($errors->all() as $error)• {{ $error }}<br>@endforeach
        </div>
    </div>
@endif

{{-- Main Content --}}
@yield('content')

{{-- Footer --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo">⚡ AutoShift</div>
                <p>Pakistan's trusted platform for buying and selling cars & bikes. Find your perfect vehicle today.</p>
                <div class="footer-socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <h4>Vehicles</h4>
                <ul>
                    <li><a href="{{ route('ads.search', ['type'=>'car']) }}">Used Cars</a></li>
                    <li><a href="{{ route('ads.search', ['type'=>'car','condition'=>'New']) }}">New Cars</a></li>
                    <li><a href="{{ route('ads.search', ['type'=>'bike']) }}">Motorcycles</a></li>
                    <li><a href="{{ route('ads.search', ['featured'=>1]) }}">Featured Ads</a></li>
                </ul>
            </div>
            <div>
                <h4>Popular Makes</h4>
                <ul>
                    <li><a href="{{ route('ads.search', ['make'=>1]) }}">Toyota</a></li>
                    <li><a href="{{ route('ads.search', ['make'=>2]) }}">Honda</a></li>
                    <li><a href="{{ route('ads.search', ['make'=>3]) }}">Suzuki</a></li>
                    <li><a href="{{ route('ads.search', ['make'=>4]) }}">Hyundai</a></li>
                    <li><a href="{{ route('ads.search', ['make'=>5]) }}">Kia</a></li>
                </ul>
            </div>
            <div>
                <h4>Cities</h4>
                <ul>
                    @foreach(['Karachi','Lahore','Islamabad','Rawalpindi','Peshawar','Faisalabad'] as $city)
                    <li><a href="{{ route('ads.search', ['city'=>$city]) }}">{{ $city }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Account</h4>
                <ul>
                    <li><a href="{{ route('ads.create') }}">Post Free Ad</a></li>
                    <li><a href="{{ route('user.my-ads') }}">My Ads</a></li>
                    <li><a href="{{ route('favorites') }}">Saved Vehicles</a></li>
                    <li><a href="{{ route('login') }}">Login / Register</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} AutoShift. All rights reserved. Made in Pakistan 🇵🇰</p>
        </div>
    </div>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
