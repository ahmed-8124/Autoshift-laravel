@extends('layouts.admin')
@section('title','Dashboard')

@section('content')
<div class="admin-title">Dashboard</div>

<div class="stat-grid">
  <div class="stat-box">
    <div class="stat-ico" style="background:#e31e24;"><i class="fas fa-car"></i></div>
    <div><h3>{{ $stats['total'] }}</h3><p>Total Ads</p></div>
  </div>
  <div class="stat-box">
    <div class="stat-ico" style="background:#f59e0b;"><i class="fas fa-clock"></i></div>
    <div><h3>{{ $stats['pending'] }}</h3><p>Pending Review</p></div>
  </div>
  <div class="stat-box">
    <div class="stat-ico" style="background:#22c55e;"><i class="fas fa-check-circle"></i></div>
    <div><h3>{{ $stats['active'] }}</h3><p>Active Ads</p></div>
  </div>
  <div class="stat-box">
    <div class="stat-ico" style="background:#3b82f6;"><i class="fas fa-users"></i></div>
    <div><h3>{{ $stats['users'] }}</h3><p>Registered Users</p></div>
  </div>
</div>

<div style="background:#fff;border-radius:12px;padding:20px;box-shadow:var(--shadow);">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <h3 style="font-family:'Syne',sans-serif;font-size:17px;font-weight:800;color:var(--navy);">Recent Ads</h3>
    <a href="{{ route('admin.ads') }}" style="color:var(--red);font-size:13px;font-weight:600;">View all →</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>ID</th><th>Vehicle</th><th>Seller</th><th>Price</th><th>City</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @foreach($recentAds as $ad)
    <tr>
      <td>#{{ $ad->id }}</td>
      <td><strong>{{ $ad->title() }}</strong><br><small style="color:var(--muted);">{{ ucfirst($ad->type) }}</small></td>
      <td>{{ $ad->user->name ?? 'N/A' }}</td>
      <td>{{ $ad->formattedPrice() }}</td>
      <td>{{ $ad->city }}</td>
      <td><span class="status status-{{ $ad->status }}">{{ ucfirst($ad->status) }}</span></td>
      <td>
        @if($ad->status === 'pending')
        <a href="{{ route('admin.ads.approve',$ad->id) }}" class="btn" style="background:#dcfce7;color:#166534;padding:5px 12px;font-size:12px;">✓ Approve</a>
        @else
        <a href="{{ route('ads.show',$ad->id) }}" target="_blank" class="btn" style="background:#dbeafe;color:#1e40af;padding:5px 12px;font-size:12px;">View</a>
        @endif
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
@endsection
