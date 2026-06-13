@extends('layouts.app')
@section('title', 'Search Vehicles')

@section('content')
<div class="container">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> ›
    <span>{{ request('type') ? ucfirst(request('type')).'s' : 'All Vehicles' }}</span>
  </div>

  <div class="search-layout">

    {{-- Filter Panel --}}
    <aside class="filter-panel">
      <h3><i class="fas fa-sliders-h"></i> Filters</h3>
      <form method="GET" action="{{ route('ads.search') }}">
        <div class="filter-group">
          <label>Vehicle Type</label>
          <select name="type">
            <option value="">All</option>
            <option value="car"  {{ request('type')==='car'  ?'selected':'' }}>Cars</option>
            <option value="bike" {{ request('type')==='bike' ?'selected':'' }}>Bikes</option>
          </select>
        </div>
        <div class="filter-group">
          <label>Make</label>
          <select name="make">
            <option value="">All Makes</option>
            @foreach($makes as $mk)
            <option value="{{ $mk->id }}" {{ request('make')==$mk->id ?'selected':'' }}>{{ $mk->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>Model</label>
          <input type="text" name="model" value="{{ request('model') }}" placeholder="e.g. Corolla">
        </div>
        <div class="filter-group">
          <label>City</label>
          <select name="city">
            <option value="">All Cities</option>
            @foreach($cities as $c)
            <option value="{{ $c }}" {{ request('city')===$c ?'selected':'' }}>{{ $c }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>Price Range (Rs.)</label>
          <div class="price-range">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max">
          </div>
        </div>
        <div class="filter-group">
          <label>Year</label>
          <div class="price-range">
            <select name="min_year">
              <option value="">From</option>
              @foreach($years as $y)
              <option value="{{ $y }}" {{ request('min_year')==$y ?'selected':'' }}>{{ $y }}</option>
              @endforeach
            </select>
            <select name="max_year">
              <option value="">To</option>
              @foreach($years as $y)
              <option value="{{ $y }}" {{ request('max_year')==$y ?'selected':'' }}>{{ $y }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="filter-group">
          <label>Fuel Type</label>
          <select name="fuel">
            <option value="">Any</option>
            @foreach(config('autoshift.fuel_types') as $f)
            <option value="{{ $f }}" {{ request('fuel')===$f ?'selected':'' }}>{{ $f }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>Transmission</label>
          <select name="trans">
            <option value="">Any</option>
            <option value="Manual"    {{ request('trans')==='Manual'    ?'selected':'' }}>Manual</option>
            <option value="Automatic" {{ request('trans')==='Automatic' ?'selected':'' }}>Automatic</option>
          </select>
        </div>
        <div class="filter-group">
          <label>Condition</label>
          <select name="condition">
            <option value="">Any</option>
            <option value="Used" {{ request('condition')==='Used' ?'selected':'' }}>Used</option>
            <option value="New"  {{ request('condition')==='New'  ?'selected':'' }}>New</option>
          </select>
        </div>
        <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Apply Filters</button>
        <a href="{{ route('ads.search') }}" class="btn-clear">Clear All</a>
      </form>
    </aside>

    {{-- Results --}}
    <div>
      <div class="results-header">
        <div class="results-count">
          <strong>{{ $ads->total() }}</strong> vehicles found
          @if(request('type')) in <strong>{{ ucfirst(request('type')) }}s</strong>@endif
          @if(request('city')) in <strong>{{ request('city') }}</strong>@endif
        </div>
        <form method="GET" action="{{ route('ads.search') }}" id="sort-form">
          @foreach(request()->except('sort') as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endforeach
          <select name="sort" class="sort-select" onchange="document.getElementById('sort-form').submit()">
            <option value="newest"     {{ request('sort')==='newest'     ?'selected':'' }}>Newest First</option>
            <option value="price_low"  {{ request('sort')==='price_low'  ?'selected':'' }}>Price: Low to High</option>
            <option value="price_high" {{ request('sort')==='price_high' ?'selected':'' }}>Price: High to Low</option>
            <option value="mileage"    {{ request('sort')==='mileage'    ?'selected':'' }}>Lowest Mileage</option>
          </select>
        </form>
      </div>

      @if($ads->isEmpty())
      <div class="empty">
        <i class="fas fa-car-crash"></i>
        <h3>No vehicles found</h3>
        <p>Try adjusting your filters</p>
        <a href="{{ route('ads.search') }}" class="btn btn-red">Clear Filters</a>
      </div>
      @else

      <div class="ads-list">
        @foreach($ads as $ad)
        <div class="ad-card-h">
          <div class="ad-thumb">
            <div class="ad-thumb-placeholder {{ $ad->type==='bike' ? 'bike-ph' : 'car-ph' }}" style="height:100%;">{{ $ad->emoji() }}</div>
            <div class="ad-badges">
              @if($ad->featured)<span class="badge badge-featured">Featured</span>@endif
              @if($ad->condition_type==='New')<span class="badge badge-new">New</span>@endif
            </div>
          </div>
          <div class="ad-card-h-body">
            <div class="ad-card-h-top">
              <h3>{{ $ad->title() }}</h3>
              <div class="price">{{ $ad->formattedPrice() }}</div>
            </div>
            <div class="ad-specs">
              <div class="spec-item"><i class="fas fa-tachometer-alt"></i>{{ number_format($ad->mileage) }} km</div>
              <div class="spec-item"><i class="fas fa-gas-pump"></i>{{ $ad->fuel_type }}</div>
              <div class="spec-item"><i class="fas fa-cog"></i>{{ $ad->transmission }}</div>
              @if($ad->engine_cc)<div class="spec-item"><i class="fas fa-circle"></i>{{ $ad->engine_cc }}cc</div>@endif
              <div class="spec-item"><i class="fas fa-palette"></i>{{ $ad->color }}</div>
            </div>
            <div class="ad-card-h-foot">
              <div>
                <div class="ad-location"><i class="fas fa-map-marker-alt"></i> {{ $ad->city }}</div>
                <div class="ad-time">{{ $ad->created_at->diffForHumans() }}</div>
              </div>
              <a href="{{ route('ads.show', $ad->id) }}" class="btn-view">View Details →</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div style="margin-top:24px;">
        {{ $ads->withQueryString()->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
