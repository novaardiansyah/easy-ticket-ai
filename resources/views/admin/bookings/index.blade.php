@extends('layouts.app')

@section('title', 'Bookings')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Bookings</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Bookings</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">All Bookings</span></div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Booking Code</th><th>Customer</th><th>Schedule</th><th>Total</th><th>Status</th><th>Booked At</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($bookings as $booking)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><span class="badge bg-dark">{{ $booking->booking_code }}</span></td>
          <td>{{ $booking->customer_name ?: $booking->user?->name ?: '-' }}</td>
          <td>{{ $booking->schedule->train->code ?? '-' }} &middot; {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M H:i') }}</td>
          <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
          <td>
            <span class="badge bg-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : 'secondary')) }}">
              {{ $booking->status }}
            </span>
          </td>
          <td>{{ $booking->created_at->format('d M H:i') }}</td>
          <td>
            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-secondary py-3">No bookings found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
