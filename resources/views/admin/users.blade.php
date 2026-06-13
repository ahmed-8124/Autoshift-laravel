@extends('layouts.admin')
@section('title','Users')

@section('content')
<div class="admin-title">Registered Users</div>
<table class="admin-table">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Ads</th><th>Role</th><th>Joined</th></tr></thead>
  <tbody>
  @foreach($users as $user)
  <tr>
    <td>#{{ $user->id }}</td>
    <td><strong>{{ $user->name }}</strong></td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone ?? '—' }}</td>
    <td>{{ $user->city ?? '—' }}</td>
    <td><strong style="color:var(--red);">{{ $user->ads_count }}</strong></td>
    <td>
      @if($user->is_admin)
        <span class="status" style="background:#dbeafe;color:#1e40af;">Admin</span>
      @else
        <span class="status status-active">User</span>
      @endif
    </td>
    <td>{{ $user->created_at->format('d M Y') }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
<div style="margin-top:16px;">{{ $users->links() }}</div>
@endsection
