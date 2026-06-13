@extends('layouts.app')
@section('title','Saved Vehicles')

@section('content')
<div class="container">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> › <span>Saved Vehicles</span></div>
  <h1 style="font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:var(--navy);margin:10px 0 24px;">
    <i class="fas fa-heart" style="color:var(--red);"></i> Saved Vehicles
  </h1>
  @if($favorites->isEmpty())
  <div class="empty">
    <i class="far fa-heart"></i>
    <h3>No saved vehicles</h3>
    <p>Browse vehicles and tap the heart icon to save them here</p>
    <a href="{{ route('ads.search') }}" class="btn btn-red">Browse Vehicles</a>
  </div>
  @else
  <div class="ads-grid">
    @foreach($favorites as $ad)
    @include('ads._card', ['ad' => $ad])
    @endforeach
  </div>
  {{ $favorites->links() }}
  @endif
</div>
@endsection
