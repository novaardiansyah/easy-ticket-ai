@extends('layouts.app')

@section('title', 'Booking Detail')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Booking Detail</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
          <li class="breadcrumb-item active">{{ $booking->booking_code }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header"><span class="card-title">Booking Info</span></div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Booking Code</dt>
          <dd class="col-sm-8"><span class="badge bg-dark">{{ $booking->booking_code }}</span></dd>

          <dt class="col-sm-4">Customer</dt>
          <dd class="col-sm-8">{{ $booking->customer_name ?: $booking->user?->name ?: '-' }}</dd>

          <dt class="col-sm-4">Email</dt>
          <dd class="col-sm-8">{{ $booking->customer_email ?: '-' }}</dd>

          <dt class="col-sm-4">Phone</dt>
          <dd class="col-sm-8">{{ $booking->customer_phone ?: '-' }}</dd>

          <dt class="col-sm-4">Status</dt>
          <dd class="col-sm-8">
            <span class="badge bg-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : 'secondary')) }}">
              {{ $booking->status }}
            </span>
          </dd>

          <dt class="col-sm-4">Total Price</dt>
          <dd class="col-sm-8">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd>

          <dt class="col-sm-4">Expired At</dt>
          <dd class="col-sm-8">{{ $booking->expired_at ? \Carbon\Carbon::parse($booking->expired_at)->format('d M Y H:i') : '-' }}</dd>

          <dt class="col-sm-4">Booked At</dt>
          <dd class="col-sm-8">{{ $booking->created_at->format('d M Y H:i') }}</dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header"><span class="card-title">Schedule</span></div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Train</dt>
          <dd class="col-sm-8">{{ $booking->schedule->train->name ?? '-' }}</dd>

          <dt class="col-sm-4">Route</dt>
          <dd class="col-sm-8">{{ $booking->schedule->route->originStation->code ?? '?' }} &rarr; {{ $booking->schedule->route->destinationStation->code ?? '?' }}</dd>

          <dt class="col-sm-4">Departure</dt>
          <dd class="col-sm-8">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M Y H:i') }}</dd>

          <dt class="col-sm-4">Arrival</dt>
          <dd class="col-sm-8">{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('d M Y H:i') }}</dd>
        </dl>
      </div>
    </div>
  </div>
</div>

@if ($booking->passengers->count())
<div class="card">
  <div class="card-header"><span class="card-title">Passengers ({{ $booking->passengers->count() }})</span></div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>Name</th><th>ID Type</th><th>ID Number</th><th>Seat</th><th>Ticket Number</th></tr>
      </thead>
      <tbody>
        @foreach ($booking->passengers as $p)
        <tr>
          <td>{{ $p->passenger_name }}</td>
          <td><span class="badge bg-info">{{ strtoupper($p->passenger_id_type) }}</span></td>
          <td>{{ $p->passenger_id_number }}</td>
          <td>{{ $p->seat->seat_number ?? '-' }}</td>
          <td><span class="badge bg-dark">{{ $p->ticket_number }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@if ($booking->payment)
<div class="card">
  <div class="card-header"><span class="card-title">Payment</span></div>
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-2">Method</dt>
      <dd class="col-sm-4">{{ $booking->payment->payment_method }}</dd>
      <dt class="col-sm-2">Amount</dt>
      <dd class="col-sm-4">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</dd>
      <dt class="col-sm-2">Status</dt>
      <dd class="col-sm-4">
        <span class="badge bg-{{ $booking->payment->status === 'success' ? 'success' : ($booking->payment->status === 'pending' ? 'warning' : 'danger') }}">
          {{ $booking->payment->status }}
        </span>
      </dd>
      <dt class="col-sm-2">Transaction ID</dt>
      <dd class="col-sm-4">{{ $booking->payment->transaction_id ?: '-' }}</dd>
      <dt class="col-sm-2">Paid At</dt>
      <dd class="col-sm-4">{{ $booking->payment->paid_at ? \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y H:i') : '-' }}</dd>
    </dl>
  </div>
</div>
@endif

<div class="card">
  <div class="card-header"><span class="card-title">Update Status</span></div>
  <div class="card-body">
    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-flex gap-2 align-items-center">
      @csrf @method('PUT')
      <select name="status" class="form-select w-auto">
        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Paid</option>
        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="expired" {{ $booking->status === 'expired' ? 'selected' : '' }}>Expired</option>
      </select>
      <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
    </form>
  </div>
</div>

<div class="mb-3">
  <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
