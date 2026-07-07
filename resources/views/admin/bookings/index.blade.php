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
  <div class="card-header">
    <h3 class="card-title">All Bookings</h3>
    <div class="card-tools">
      <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  <div class="card-body">
    <table id="bookings-table" 
           class="table table-striped table-bordered w-100"
           data-ajax-url="{{ route('admin.bookings.index') }}"
           data-show-url-template="{{ route('admin.bookings.show', ':id') }}">
      <thead>
        <tr>
          <th>Booking Code</th>
          <th>Customer</th>
          <th>Schedule</th>
          <th>Total</th>
          <th>Status</th>
          <th>Booked At</th>
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
<script src="{{ asset('js/admin/bookings.js') }}"></script>
@endpush
