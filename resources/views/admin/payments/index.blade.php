@extends('layouts.app')

@section('title', 'Payments')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Payments</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Payments</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">All Payments</span></div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Booking</th><th>Method</th><th>Amount</th><th>Status</th><th>Transaction ID</th><th>Paid At</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($payments as $payment)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><span class="badge bg-dark">{{ $payment->booking->booking_code ?? '-' }}</span></td>
          <td>{{ $payment->payment_method }}</td>
          <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
          <td>
            <span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
              {{ $payment->status }}
            </span>
          </td>
          <td><small class="text-muted">{{ $payment->transaction_id ?: '-' }}</small></td>
          <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M H:i') : '-' }}</td>
          <td>
            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-secondary py-3">No payments found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
