@extends('layouts.app')
@section('title', 'Buy & Sell Cars and Bikes in Pakistan')

@section('content')

{{-- Hero --}}
<section class="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-tag">🇵🇰 Pakistan's Vehicle Marketplace</div>
      <h1>Find Your Perfect <span>Ride</span> in Pakistan</h1>
      <p class="hero-sub">{{ number_format($totalCars + $totalBikes) }} vehicles listed — cars, bikes, and more across all cities</p>

      <div class="search-box">
        <div class="search-tabs">
          <button class="search-tab active" data-type="car"><i class="fas fa-car"></i> Cars</button>
          <button class="search-tab" data-type="bike"><i class="fas fa-motorcycle"></i> Bikes</button>
        </div>
        <form action="{{ route('ads.search') }}" method="GET">
          <input type="hidden" name="type" id="search-type" value="car">
          <div class="search-fields">
            <select name="make">
              <option value="">All Makes</option>
              @foreach($allMakes as $mk)
                <option value="{{ $mk->id }}">{{ $mk->name }}</option>
              @endforeach
            </select>
            <input type="text" name="model" placeholder="Model (e.g. Corolla)">
            <select name="city">
              <option value="">All Cities</option>
              @foreach($cities as $c)
                <option value="{{ $c }}">{{ $c }}</option>
              @endforeach
            </select>
            <select name="max_price">
              <option value="">Any Price</option>
              <option value="500000">Under 5 Lakh</option>
              <option value="1000000">Under 10 Lakh</option>
              <option value="2000000">Under 20 Lakh</option>
              <option value="3000000">Under 30 Lakh</option>
              <option value="5000000">Under 50 Lakh</option>
            </select>
            <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

{{-- Browse by Make --}}
<section class="section" style="padding-bottom:10px;">
  <div class="container">
    <div class="section-head">
      <h2>Browse by <span>Make</span></h2>
      <a href="{{ route('ads.search') }}">View all →</a>
    </div>
    <div class="cat-grid">
      @php $makeEmojis = ['Toyota'=>'🚗','Honda'=>'🚙','Suzuki'=>'🚘','Hyundai'=>'🚕','Kia'=>'🛻','BMW'=>'🏎️','Mercedes'=>'🚐','Audi'=>'🚗']; @endphp
      @foreach($makes as $mk)
      <a href="{{ route('ads.search', ['make'=>$mk->id]) }}" class="cat-box">
        <div class="icon">{{ $makeEmojis[$mk->name] ?? '🚗' }}</div>
        <h4>{{ $mk->name }}</h4>
        <p>{{ $mk->ads_count }} ads</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Featured --}}
<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>⭐ <span>Featured</span> Vehicles</h2>
      <a href="{{ route('ads.search', ['featured'=>1]) }}">View all →</a>
    </div>
    <div class="ads-grid">
      @foreach($featured as $ad)
      @include('ads._card', ['ad' => $ad])
      @endforeach
    </div>
  </div>
</section>

{{-- Latest Cars --}}
<section class="section" style="background:#fff;padding:40px 0;">
  <div class="container">
    <div class="section-head">
      <h2>Latest <span>Cars</span></h2>
      <a href="{{ route('ads.search', ['type'=>'car']) }}">All Cars →</a>
    </div>
    <div class="ads-grid">
      @foreach($latestCars as $ad)
      @include('ads._card', ['ad' => $ad])
      @endforeach
    </div>
  </div>
</section>

{{-- Latest Bikes --}}
<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>Latest <span>Bikes</span></h2>
      <a href="{{ route('ads.search', ['type'=>'bike']) }}">All Bikes →</a>
    </div>
    <div class="ads-grid">
      @foreach($latestBikes as $ad)
      @include('ads._card', ['ad' => $ad])
      @endforeach
    </div>
  </div>
</section>

{{-- Why AutoShift --}}
<section style="background:var(--navy-2);padding:50px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:36px;">
      <h2 style="font-family:'Syne',sans-serif;font-size:28px;color:#fff;font-weight:800;">Why <span style="color:var(--red);">AutoShift?</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
      @foreach([['🔒','Safe & Trusted','All ads verified by our team'],['📍','Nationwide','Listings from every city in Pakistan'],['💸','100% Free','Post your ad for free, always'],['⚡','Fast & Easy','Sell your vehicle in days']] as $perk)
      <div style="padding:24px 16px;">
        <div style="font-size:40px;margin-bottom:12px;">{{ $perk[0] }}</div>
        <h4 style="color:#fff;font-weight:700;margin-bottom:6px;">{{ $perk[1] }}</h4>
        <p style="color:rgba(255,255,255,.55);font-size:13.5px;">{{ $perk[2] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
