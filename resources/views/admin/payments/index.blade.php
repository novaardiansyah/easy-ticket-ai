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
  <div class="card-header">
    <h3 class="card-title">All Payments</h3>
  </div>
  <div class="card-body">
    <table id="payments-table" 
           class="table table-striped table-bordered w-100"
           data-ajax-url="{{ route('admin.payments.index') }}"
           data-show-url-template="{{ route('admin.payments.show', ':id') }}">
      <thead>
        <tr>
          <th>Booking</th>
          <th>Method</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Transaction ID</th>
          <th>Paid At</th>
          <th style="width: 120px;">Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/payments.js') }}"></script>
@endpush
