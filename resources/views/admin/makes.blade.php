@extends('layouts.admin')
@section('title','Manage Makes')

@section('content')
<div class="admin-title">Manage Makes</div>

<div style="display:grid;grid-template-columns:320px 1fr;gap:22px;">
  <div style="background:#fff;border-radius:12px;padding:22px;box-shadow:var(--shadow);height:fit-content;">
    <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:800;color:var(--navy);margin-bottom:16px;">Add New Make</h3>
    <form method="POST" action="{{ route('admin.makes.store') }}">
      @csrf
      <div class="form-group">
        <label>Make Name *</label>
        <input type="text" name="name" required placeholder="e.g. Toyota">
      </div>
      <div class="form-group">
        <label>Type *</label>
        <select name="type">
          <option value="car">Car</option>
          <option value="bike">Bike</option>
          <option value="both">Both</option>
        </select>
      </div>
      <button type="submit" class="btn btn-red btn-block">Add Make</button>
    </form>
  </div>

  <div>
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Ads</th><th>Action</th></tr></thead>
      <tbody>
      @foreach($makes as $mk)
      <tr>
        <td>{{ $mk->id }}</td>
        <td><strong>{{ $mk->name }}</strong></td>
        <td>{{ ucfirst($mk->type) }}</td>
        <td>{{ $mk->ads_count }}</td>
        <td>
          @if($mk->ads_count == 0)
          <form method="POST" action="{{ route('admin.makes.delete',$mk->id) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirmDelete('Delete {{ $mk->name }}?')" class="btn" style="background:#fee2e2;color:#991b1b;padding:5px 12px;font-size:12px;">Delete</button>
          </form>
          @else
          <span style="color:var(--muted);font-size:12px;">Has ads</span>
          @endif
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
