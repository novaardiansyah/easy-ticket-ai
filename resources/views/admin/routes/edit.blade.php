@extends('layouts.app')

@section('title', 'Edit Route')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Edit Route</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.routes.index') }}">Routes</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">Route Details</span></div>
  <div class="card-body">
    <form action="{{ route('admin.routes.update', $route) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Origin Station <span class="text-danger">*</span></label>
        <select name="origin_station_id" class="form-select @error('origin_station_id') is-invalid @enderror" required>
          <option value="">Select Station</option>
          @foreach ($stations as $s)
          <option value="{{ $s->id }}" {{ old('origin_station_id', $route->origin_station_id) == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->code }})</option>
          @endforeach
        </select>
        @error('origin_station_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Destination Station <span class="text-danger">*</span></label>
        <select name="destination_station_id" class="form-select @error('destination_station_id') is-invalid @enderror" required>
          <option value="">Select Station</option>
          @foreach ($stations as $s)
          <option value="{{ $s->id }}" {{ old('destination_station_id', $route->destination_station_id) == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->code }})</option>
          @endforeach
        </select>
        @error('destination_station_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Distance (km)</label>
        <input type="number" name="distance_km" class="form-control @error('distance_km') is-invalid @enderror" value="{{ old('distance_km', $route->distance_km) }}" step="0.01" min="0">
        @error('distance_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Estimated Duration (minutes)</label>
        <input type="number" name="estimated_duration" class="form-control @error('estimated_duration') is-invalid @enderror" value="{{ old('estimated_duration', $route->estimated_duration) }}" min="1">
        @error('estimated_duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
