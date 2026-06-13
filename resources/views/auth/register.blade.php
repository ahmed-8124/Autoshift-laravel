@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container">
<div class="auth-wrap" style="max-width:520px;">
  <div class="auth-card">
    <h2>Create Account</h2>
    <p>Join AutoShift and start buying or selling</p>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="name" required value="{{ old('name') }}" placeholder="Ali Hassan">
        </div>
        <div class="form-group">
          <label>Phone *</label>
          <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="0300-1234567">
        </div>
      </div>
      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@example.com">
      </div>
      <div class="form-group">
        <label>City *</label>
        <select name="city" required>
          <option value="">Select City</option>
          @foreach($cities as $c)
          <option value="{{ $c }}" {{ old('city')===$c?'selected':'' }}>{{ $c }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Password *</label>
          <input type="password" name="password" required placeholder="Min 6 characters">
        </div>
        <div class="form-group">
          <label>Confirm Password *</label>
          <input type="password" name="password_confirmation" required placeholder="Repeat password">
        </div>
      </div>
      <button type="submit" class="btn btn-red btn-block">Create Account</button>
    </form>
    <div class="auth-footer">Already have an account? <a href="{{ route('login') }}">Login here</a></div>
  </div>
</div>
</div>
@endsection
