@extends('layouts.admin')
@section('title','Manage Ads')

@section('content')
<div class="admin-title">Manage Ads</div>

{{-- Filter tabs --}}
<div style="display:flex;gap:8px;margin-bottom:18px;flex-wrap:wrap;">
  @foreach([''=> 'All','pending'=>'Pending','active'=>'Active','rejected'=>'Rejected','sold'=>'Sold'] as $val => $label)
  <a href="{{ route('admin.ads', $val ? ['status'=>$val] : []) }}"
     class="btn" style="padding:7px 16px;font-size:13px;background:{{ request('status')===$val?'var(--red)':'#fff' }};color:{{ request('status')===$val?'#fff':'var(--text)' }};box-shadow:var(--shadow);">
    {{ $label }}
  </a>
  @endforeach
</div>

<table class="admin-table">
  <thead>
    <tr><th>ID</th><th>Vehicle</th><th>Seller</th><th>Price</th><th>City</th><th>Status</th><th>Views</th><th>Actions</th></tr>
  </thead>
  <tbody>
  @foreach($ads as $ad)
  <tr>
    <td>#{{ $ad->id }}</td>
    <td>
      <strong>{{ $ad->title() }}</strong><br>
      <small style="color:var(--muted);">{{ ucfirst($ad->type) }} · {{ $ad->fuel_type }} · {{ $ad->transmission }}</small>
    </td>
    <td>{{ $ad->user->name ?? 'N/A' }}<br><small>{{ $ad->user->phone ?? '' }}</small></td>
    <td><strong>{{ $ad->formattedPrice() }}</strong></td>
    <td>{{ $ad->city }}</td>
    <td>
      <span class="status status-{{ $ad->status }}">{{ ucfirst($ad->status) }}</span>
      @if($ad->featured)<br><span style="font-size:11px;color:#f59e0b;">⭐ Featured</span>@endif
    </td>
    <td>{{ $ad->views }}</td>
    <td style="white-space:nowrap;">
      @if($ad->status === 'pending')
        <a href="{{ route('admin.ads.approve',$ad->id) }}" class="btn" style="background:#dcfce7;color:#166534;padding:5px 10px;font-size:12px;margin-right:3px;">✓ Approve</a>
        <a href="{{ route('admin.ads.reject',$ad->id) }}"  class="btn" style="background:#fee2e2;color:#991b1b;padding:5px 10px;font-size:12px;margin-right:3px;">✗ Reject</a>
      @else
        <a href="{{ route('ads.show',$ad->id) }}" target="_blank" class="btn" style="background:#dbeafe;color:#1e40af;padding:5px 10px;font-size:12px;margin-right:3px;">View</a>
        <a href="{{ route('admin.ads.feature',$ad->id) }}" class="btn" style="background:#fef9c3;color:#854d0e;padding:5px 10px;font-size:12px;margin-right:3px;">{{ $ad->featured?'Unfeature':'Feature' }}</a>
      @endif
      <form method="POST" action="{{ route('admin.ads.delete',$ad->id) }}" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" onclick="return confirmDelete('Delete this ad?')" class="btn" style="background:#fee2e2;color:#991b1b;padding:5px 10px;font-size:12px;">🗑</button>
      </form>
    </td>
  </tr>
  @endforeach
  </tbody>
</table>
<div style="margin-top:16px;">{{ $ads->withQueryString()->links() }}</div>
@endsection
