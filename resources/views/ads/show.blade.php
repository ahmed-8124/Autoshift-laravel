@extends('layouts.app')
@section('title', $ad->title())

@section('content')
<div class="container">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> ›
    <a href="{{ route('ads.search', ['type'=>$ad->type]) }}">{{ ucfirst($ad->type) }}s</a> ›
    <a href="{{ route('ads.search', ['make'=>$ad->make_id]) }}">{{ $ad->make->name }}</a> ›
    <span>{{ $ad->model }}</span>
  </div>

  <div class="detail-layout">
    {{-- Left --}}
    <div>
      <div class="detail-gallery">
        <div class="main-img {{ $ad->type==='bike' ? 'bike-ph' : 'car-ph' }}">{{ $ad->emoji() }}</div>
      </div>

      <div class="detail-card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;">
          <div>
            @if($ad->featured)
              <span class="badge badge-featured" style="font-size:12px;margin-bottom:8px;display:inline-block;">⭐ Featured</span>
            @endif
            <h2>{{ $ad->title() }}</h2>
            <div class="detail-price">{{ $ad->formattedPrice() }}</div>
          </div>
          <div style="text-align:right;font-size:13px;color:var(--muted);">
            <div><i class="fas fa-eye"></i> {{ $ad->views }} views</div>
            <div style="margin-top:4px;"><i class="fas fa-clock"></i> {{ $ad->created_at->diffForHumans() }}</div>
            <div style="margin-top:4px;"><i class="fas fa-map-marker-alt"></i> {{ $ad->city }}</div>
          </div>
        </div>

        <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:800;color:var(--navy);margin:20px 0 12px;">Vehicle Details</h3>
        <div class="specs-grid">
          @foreach([
            'Make'         => $ad->make->name,
            'Model'        => $ad->model,
            'Year'         => $ad->year,
            'Mileage'      => number_format($ad->mileage).' km',
            'Fuel Type'    => $ad->fuel_type,
            'Transmission' => $ad->transmission,
            'Engine'       => $ad->engine_cc ? $ad->engine_cc.'cc' : 'N/A',
            'Color'        => $ad->color ?? 'N/A',
            'Condition'    => $ad->condition_type,
            'Type'         => ucfirst($ad->type),
          ] as $label => $val)
          <div class="spec-row">
            <span class="spec-label">{{ $label }}</span>
            <span class="spec-val">{{ $val }}</span>
          </div>
          @endforeach
        </div>
      </div>

      @if($ad->description)
      <div class="detail-card">
        <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:800;color:var(--navy);margin-bottom:12px;">Description</h3>
        <p style="color:var(--muted);line-height:1.8;font-size:14.5px;">{{ nl2br(e($ad->description)) }}</p>
      </div>
      @endif
    </div>

    {{-- Right: Seller --}}
    <div>
      <div class="seller-card">
        <h3>Seller Info</h3>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
          <div style="width:46px;height:46px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;">
            {{ strtoupper(substr($ad->user->name, 0, 1)) }}
          </div>
          <div>
            <div class="seller-name">{{ $ad->user->name }}</div>
            <div class="seller-city"><i class="fas fa-map-marker-alt"></i> {{ $ad->user->city }}</div>
          </div>
        </div>

        @auth
          <a href="tel:{{ $ad->user->phone }}" class="btn-call">
            <i class="fas fa-phone"></i> {{ $ad->user->phone }}
          </a>
          @if($ad->user->phone)
          <a href="https://wa.me/92{{ ltrim(str_replace('-','',$ad->user->phone),'0') }}?text={{ urlencode('Hi, I saw your '.$ad->title().' ad on AutoShift') }}"
             target="_blank" class="btn-whatsapp" style="margin-top:10px;display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25d366;color:#fff;padding:13px;border-radius:8px;font-weight:700;font-size:15px;">
            <i class="fab fa-whatsapp"></i> WhatsApp Seller
          </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="btn-call">
            <i class="fas fa-lock"></i> Login to See Phone
          </a>
          <p style="text-align:center;font-size:12.5px;color:var(--muted);margin-top:8px;">Login or register to contact seller</p>
        @endauth

        <button onclick="toggleFav(this, {{ $ad->id }})"
                class="btn-fav-full {{ $isFav ? 'active' : '' }}">
          <i class="{{ $isFav ? 'fas' : 'far' }} fa-heart"></i>
          {{ $isFav ? 'Saved' : 'Save Ad' }}
        </button>

        <div style="margin-top:16px;padding:12px;background:var(--off);border-radius:8px;font-size:12.5px;color:var(--muted);">
          <i class="fas fa-shield-alt" style="color:var(--red);"></i>
          Meet in a safe public place. Do not send advance payment without verifying the vehicle.
        </div>
      </div>
    </div>
  </div>

  {{-- Similar Ads --}}
  @if($similar->count())
  <div class="section" style="padding-top:10px;">
    <div class="section-head">
      <h2>Similar <span>{{ $ad->make->name }}</span> Ads</h2>
    </div>
    <div class="ads-grid">
      @foreach($similar as $s)
      @include('ads._card', ['ad' => $s])
      @endforeach
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function toggleFav(btn, adId) {
    fetch('/favorite/' + adId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.action === 'added') {
            btn.innerHTML = '<i class="fas fa-heart"></i> Saved';
            btn.classList.add('active');
        } else if (data.action === 'removed') {
            btn.innerHTML = '<i class="far fa-heart"></i> Save Ad';
            btn.classList.remove('active');
        } else {
            window.location.href = '/login';
        }
    });
}
</script>
@endpush
