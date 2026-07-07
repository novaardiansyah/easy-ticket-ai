@extends('layouts.app')

@section('title', 'Payment Detail')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Payment Detail</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
          <li class="breadcrumb-item active">#{{ $payment->id }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">Payment #{{ $payment->id }}</span></div>
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-2">Booking</dt>
      <dd class="col-sm-4"><span class="badge bg-dark">{{ $payment->booking->booking_code ?? '-' }}</span></dd>
      <dt class="col-sm-2">Customer</dt>
      <dd class="col-sm-4">{{ $payment->booking->customer_name ?: $payment->booking->user?->name ?: '-' }}</dd>

      <dt class="col-sm-2">Method</dt>
      <dd class="col-sm-4">{{ $payment->payment_method }}</dd>
      <dt class="col-sm-2">Amount</dt>
      <dd class="col-sm-4">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>

      <dt class="col-sm-2">Status</dt>
      <dd class="col-sm-4">
        <span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
          {{ $payment->status }}
        </span>
      </dd>
      <dt class="col-sm-2">Transaction ID</dt>
      <dd class="col-sm-4">{{ $payment->transaction_id ?: '-' }}</dd>

      <dt class="col-sm-2">Paid At</dt>
      <dd class="col-sm-4">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') : '-' }}</dd>
      <dt class="col-sm-2">Created</dt>
      <dd class="col-sm-4">{{ $payment->created_at->format('d M Y H:i') }}</dd>
    </dl>
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
