@php
    $ph = $ad->type === 'bike' ? 'bike-ph' : 'car-ph';
@endphp
<div class="ad-card">
    <div class="ad-thumb">
        <div class="ad-thumb-placeholder {{ $ph }}">{{ $ad->emoji() }}</div>
        <div class="ad-badges">
            @if($ad->featured)<span class="badge badge-featured">⭐ Featured</span>@endif
            @if($ad->condition_type === 'New')<span class="badge badge-new">New</span>@endif
        </div>
        @auth
        <button onclick="toggleFav(this, {{ $ad->id }})" class="fav-btn">
            <i class="far fa-heart"></i>
        </button>
        @endauth
    </div>
    <div class="ad-info">
        <div class="ad-title">{{ $ad->title() }}</div>
        <div class="ad-price">{{ $ad->formattedPrice() }}</div>
        <div class="ad-meta">
            <span><i class="fas fa-tachometer-alt"></i> {{ number_format($ad->mileage) }} km</span>
            <span><i class="fas fa-gas-pump"></i> {{ $ad->fuel_type }}</span>
            <span><i class="fas fa-cog"></i> {{ $ad->transmission }}</span>
        </div>
    </div>
    <div class="ad-footer">
        <span><i class="fas fa-map-marker-alt"></i> {{ $ad->city }}</span>
        <a href="{{ route('ads.show', $ad->id) }}" class="btn-view">View →</a>
    </div>
</div>
