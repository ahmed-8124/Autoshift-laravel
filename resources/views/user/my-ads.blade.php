@extends('layouts.app')
@section('title','My Ads')

@section('content')
<div class="container">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> › <span>My Ads</span></div>
  <div class="myads-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <h1 style="font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:var(--navy);">My Ads</h1>
      <a href="{{ route('ads.create') }}" class="btn btn-red"><i class="fas fa-plus"></i> Post New Ad</a>
    </div>

    @if($ads->isEmpty())
    <div class="empty">
      <i class="fas fa-car"></i>
      <h3>No ads yet</h3>
      <p>You haven't posted any ads. Start selling today!</p>
      <a href="{{ route('ads.create') }}" class="btn btn-red">Post Free Ad</a>
    </div>
    @else
    <div class="ads-list">
      @foreach($ads as $ad)
      <div class="ad-card-h" style="opacity:{{ $ad->status==='sold'?'.7':'1' }};">
        <div class="ad-thumb">
          <div class="ad-thumb-placeholder {{ $ad->type==='bike'?'bike-ph':'car-ph' }}" style="height:100%;">{{ $ad->emoji() }}</div>
          <div class="ad-badges">
            <span class="status status-{{ $ad->status }}">{{ ucfirst($ad->status) }}</span>
          </div>
        </div>
        <div class="ad-card-h-body">
          <div class="ad-card-h-top">
            <h3>{{ $ad->title() }}</h3>
            <div class="price">{{ $ad->formattedPrice() }}</div>
          </div>
          <div class="ad-specs">
            <div class="spec-item"><i class="fas fa-eye"></i>{{ $ad->views }} views</div>
            <div class="spec-item"><i class="fas fa-map-marker-alt"></i>{{ $ad->city }}</div>
            <div class="spec-item"><i class="fas fa-clock"></i>{{ $ad->created_at->diffForHumans() }}</div>
          </div>
          <div class="ad-card-h-foot">
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
              @if($ad->status==='active')
              <a href="{{ route('ads.show',$ad->id) }}" class="btn btn-outline" style="padding:7px 16px;font-size:13px;">View</a>
              <a href="{{ route('user.sold',$ad->id) }}" onclick="return confirm('Mark as sold?')" class="btn" style="background:#22c55e;color:#fff;padding:7px 16px;font-size:13px;">Mark Sold</a>
              @endif
              <form method="POST" action="{{ route('user.delete-ad',$ad->id) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirmDelete('Delete this ad permanently?')" class="btn" style="background:#fee2e2;color:#991b1b;padding:7px 16px;font-size:13px;">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
            @if($ad->status==='pending')
            <span style="font-size:12px;color:#92400e;"><i class="fas fa-clock"></i> Under review</span>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    {{ $ads->links() }}
    @endif
  </div>
</div>
@endsection
