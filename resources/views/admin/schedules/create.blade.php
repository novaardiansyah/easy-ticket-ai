@extends('layouts.app')

@section('title', 'Create Schedule')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Create Schedule</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Schedules</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">Schedule Details</span></div>
  <div class="card-body">
    <form action="{{ route('admin.schedules.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Train <span class="text-danger">*</span></label>
        <select name="train_id" class="form-select @error('train_id') is-invalid @enderror" required>
          <option value="">Select Train</option>
          @foreach ($trains as $train)
          <option value="{{ $train->id }}" {{ old('train_id') == $train->id ? 'selected' : '' }}>{{ $train->name }} ({{ $train->code }})</option>
          @endforeach
        </select>
        @error('train_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Route <span class="text-danger">*</span></label>
        <select name="route_id" id="route_id" class="form-select select2 @error('route_id') is-invalid @enderror" required>
          <option value="">Select Route</option>
          @foreach ($routes as $route)
          <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
            {{ $route->originStation->city ?? '?' }} - {{ $route->originStation->name ?? '?' }} ({{ $route->originStation->code ?? '?' }}) &rarr; {{ $route->destinationStation->city ?? '?' }} - {{ $route->destinationStation->name ?? '?' }} ({{ $route->destinationStation->code ?? '?' }})
          </option>
          @endforeach
        </select>
        @error('route_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Departure Time <span class="text-danger">*</span></label>
        <input type="text" name="departure_time" id="departure_time" class="form-control @error('departure_time') is-invalid @enderror" value="{{ old('departure_time') }}" required>
        @error('departure_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Arrival Time <span class="text-danger">*</span></label>
        <input type="text" name="arrival_time" id="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror" value="{{ old('arrival_time') }}" required>
        @error('arrival_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label" id="base_price_label">
          Base Price <span class="text-danger">*</span>
          <small class="text-muted ms-2" id="base_price_hint"></small>
        </label>
        <input type="number" name="base_price" id="base_price" class="form-control @error('base_price') is-invalid @enderror" value="{{ old('base_price') }}" step="0.01" min="0" required>
        @error('base_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

  flatpickr('#departure_time', {
    locale: 'id',
    enableTime: true,
    dateFormat: 'Y-m-d H:i:s',
    altInput: true,
    altFormat: 'd/m/Y H:i',
    disableMobile: true,
    position: 'above',
  });

  flatpickr('#arrival_time', {
    locale: 'id',
    enableTime: true,
    dateFormat: 'Y-m-d H:i:s',
    altInput: true,
    altFormat: 'd/m/Y H:i',
    disableMobile: true,
    position: 'above',
  });

  var debounceTimer;
  var priceInput = document.getElementById('base_price');
  var priceHint = document.getElementById('base_price_hint');

  priceInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function () {
      var val = priceInput.value.trim();
      if (val !== '' && !isNaN(val) && Number(val) > 0) {
        priceHint.textContent = formatRupiah(val);
      } else {
        priceHint.textContent = '';
      }
    }, 500);
  });
});
</script>
@endpush
