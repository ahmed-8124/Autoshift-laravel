@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container">
<div class="auth-wrap">
  <div class="auth-card">
    <h2>Welcome Back</h2>
    <p>Login to your AutoShift account</p>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" required value="{{ old('email') }}" placeholder="your@email.com">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="Enter password">
      </div>
      <div class="form-group" style="display:flex;align-items:center;gap:8px;">
        <input type="checkbox" name="remember" id="remember" style="width:auto;">
        <label for="remember" style="font-weight:400;margin:0;">Remember me</label>
      </div>
      <button type="submit" class="btn btn-red btn-block">Login</button>
    </form>
    <div class="auth-footer">
      Don't have an account? <a href="{{ route('register') }}">Register free</a>
    </div>
    <div style="margin-top:14px;padding:12px;background:var(--off);border-radius:6px;font-size:12.5px;color:var(--muted);">
      <strong>Demo Admin:</strong> admin@autoshift.pk / admin123
    </div>
  </div>
</div>
</div>
@endsection
