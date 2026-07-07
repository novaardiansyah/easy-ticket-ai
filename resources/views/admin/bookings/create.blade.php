@extends('layouts.app')

@section('title', 'Create Booking')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Create Booking</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Book Ticket for Customer</h3>
  </div>
  <form action="{{ route('admin.bookings.store') }}" method="POST" id="booking-form">
    @csrf
    <div class="card-body">
      @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please check the inputs below:
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="schedule_id" class="form-label">Schedule <span class="text-danger">*</span></label>
          <select name="schedule_id" id="schedule_id" class="form-select @error('schedule_id') is-invalid @enderror" required>
            <option value="">Select Schedule</option>
            @foreach ($schedules as $s)
            <option value="{{ $s->id }}" data-price="{{ $s->base_price }}">
              {{ $s->train->name }} ({{ $s->train->code }}) | {{ $s->route->originStation->code }} &rarr; {{ $s->route->destinationStation->code }} | {{ $s->departure_time }} (Rp {{ number_format($s->base_price, 0, ',', '.') }})
            </option>
            @endforeach
          </select>
          @error('schedule_id')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-3 mb-3">
          <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
          <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
            <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
            <option value="ewallet" {{ old('payment_method') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
          </select>
          @error('payment_method')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-3 mb-3">
          <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
          <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
            <option value="success" {{ old('payment_status') === 'success' ? 'selected' : '' }}>Success (Paid)</option>
            <option value="pending" {{ old('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
          </select>
          @error('payment_status')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <h5 class="mt-4 mb-3 border-bottom pb-2">Customer / Contact Information</h5>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
          <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
          @error('customer_name')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-md-4 mb-3">
          <label for="customer_email" class="form-label">Customer Email <span class="text-danger">*</span></label>
          <input type="email" name="customer_email" id="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email') }}" required>
          @error('customer_email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-md-4 mb-3">
          <label for="customer_phone" class="form-label">Customer Phone <span class="text-danger">*</span></label>
          <input type="text" name="customer_phone" id="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}" required>
          @error('customer_phone')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
        <h5 class="mb-0">Passengers & Seat Selection</h5>
        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-passenger" disabled>
          <i class="bi bi-plus-lg"></i> Add Passenger
        </button>
      </div>

      <div id="passengers-container">
      </div>

      <div class="row mt-4">
        <div class="col-md-6 offset-md-6 text-end">
          <h4>Total Price: <span id="total-price-display" class="text-primary font-weight-bold">Rp 0</span></h4>
        </div>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary" id="btn-submit" disabled>Submit Booking</button>
    </div>
  </form>
</div>

<template id="passenger-row-template">
  <div class="card card-outline card-secondary mb-3 passenger-row" data-index="{index}">
    <div class="card-header d-flex justify-content-between align-items-center py-2">
      <h6 class="mb-0 card-title fs-6 text-secondary">Passenger #{number}</h6>
      <button type="button" class="btn-close btn-remove-passenger" aria-label="Remove"></button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 mb-2">
          <label class="form-label small">Passenger Name <span class="text-danger">*</span></label>
          <input type="text" name="passengers[{index}][passenger_name]" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-2 mb-2">
          <label class="form-label small">ID Type <span class="text-danger">*</span></label>
          <select name="passengers[{index}][passenger_id_type]" class="form-select form-select-sm" required>
            <option value="ktp">KTP</option>
            <option value="passport">Passport</option>
            <option value="sim">SIM</option>
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <label class="form-label small">ID Number <span class="text-danger">*</span></label>
          <input type="text" name="passengers[{index}][passenger_id_number]" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-3 mb-2">
          <label class="form-label small">Seat Selection <span class="text-danger">*</span></label>
          <select name="passengers[{index}][seat_id]" class="form-select form-select-sm select-seat" required>
            <option value="">Select Seat</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>
@endsection

@push('scripts')
<script>
  const getSeatsUrl = '{{ route('admin.bookings.get-seats') }}';
</script>
<script src="{{ asset('js/admin/bookings-create.js') }}"></script>
@endpush
