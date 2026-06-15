@extends('layouts.app')
@section('title', 'Post Free Ad')

@section('content')
<div class="container">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> › <span>Post Free Ad</span></div>

  <div class="post-container">
    <div style="text-align:center;margin-bottom:28px;">
      <h1 style="font-family:'Syne',sans-serif;font-size:30px;font-weight:800;color:var(--navy);">Post Your <span style="color:var(--red);">Free Ad</span></h1>
      <p style="color:var(--muted);">Reach thousands of buyers across Pakistan</p>
    </div>

    <form method="POST" action="{{ route('ads.store') }}">
      @csrf

      {{-- Step 1: Type --}}
      <div class="post-card">
        <h3>Step 1 — Vehicle Type</h3>
        <input type="hidden" name="type" id="ad-type" value="{{ old('type','car') }}">
        <div class="type-toggle">
          <div class="type-btn {{ old('type','car')==='car' ? 'active':'' }}" data-type="car">
            <i class="fas fa-car"></i> Car
          </div>
          <div class="type-btn {{ old('type')==='bike' ? 'active':'' }}" data-type="bike">
            <i class="fas fa-motorcycle"></i> Bike / Motorcycle
          </div>
        </div>
      </div>

      {{-- Step 2: Info --}}
      <div class="post-card">
        <h3>Step 2 — Vehicle Information</h3>
        <div class="form-row">
          <div class="form-group">
            <label>Make *</label>
            <select name="make_id" required>
              
              <option value="">Select Make</option>
              <option value="1">SUzuki </option>
              <option value="2">Toyota </option>
              <option value="3">Honda </option>
              @foreach($makes as $mk)
              <option value="{{ $mk->id }}" {{ old('make_id')==$mk->id?'selected':'' }}>{{ $mk->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Model *</label>
            <input type="text" name="model" value="{{ old('model') }}" placeholder="e.g. Corolla, Civic, CD70" required>
          </div>
          <div class="form-group">
            <label>Year *</label>
            <select name="year" required>
              <option value="">Select Year</option>
              @foreach($years as $y)
              <option value="{{ $y }}" {{ old('year')==$y?'selected':'' }}>{{ $y }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Price (Rs.) *</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="e.g. 2500000" required min="1">
          </div>
          <div class="form-group">
            <label>Mileage (km)</label>
            <input type="number" name="mileage" value="{{ old('mileage') }}" placeholder="e.g. 45000" min="0">
          </div>
          <div class="form-group">
            <label>Engine (cc)</label>
            <input type="number" name="engine_cc" value="{{ old('engine_cc') }}" placeholder="e.g. 1800">
          </div>
          <div class="form-group">
            <label>Fuel Type *</label>
            <select name="fuel_type" required>
              @foreach(config('autoshift.fuel_types') as $f)
              <option value="{{ $f }}" {{ old('fuel_type','Petrol')===$f?'selected':'' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Transmission *</label>
            <select name="transmission" required>
              <option value="Manual"    {{ old('transmission','Manual')==='Manual'   ?'selected':'' }}>Manual</option>
              <option value="Automatic" {{ old('transmission')==='Automatic'?'selected':'' }}>Automatic</option>
            </select>
          </div>
          <div class="form-group">
            <label>Color</label>
            <input type="text" name="color" value="{{ old('color') }}" placeholder="e.g. White, Silver">
          </div>
          <div class="form-group">
            <label>Condition *</label>
            <select name="condition_type" required>
              <option value="Used" {{ old('condition_type','Used')==='Used'?'selected':'' }}>Used</option>
              <option value="New"  {{ old('condition_type')==='New' ?'selected':'' }}>New</option>
            </select>
          </div>
        </div>
      </div>

      {{-- Step 3: Location --}}
      <div class="post-card">
        <h3>Step 3 — Location & Description</h3>
        <div class="form-group">
          <label>City *</label>
          <select name="city" required>
            <option value="">Select City</option>
            @foreach($cities as $c)
            <option value="{{ $c }}" {{ old('city')===$c?'selected':'' }}>{{ $c }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" rows="5" placeholder="Describe your vehicle — condition, features, reason for selling...">{{ old('description') }}</textarea>
        </div>
      </div>

      <div style="text-align:center;">
        <button type="submit" class="btn btn-red" style="padding:14px 50px;font-size:16px;font-family:'Syne',sans-serif;font-weight:800;">
          <i class="fas fa-paper-plane"></i> Submit Ad for Review
        </button>
        <p style="color:var(--muted);font-size:13px;margin-top:10px;">Your ad will be reviewed and published within a few hours.</p>
      </div>
    </form>
  </div>
</div>
@endsection
