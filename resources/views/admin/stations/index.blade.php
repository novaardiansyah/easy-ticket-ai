@extends('layouts.app')

@section('title', 'Stations')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Stations</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Stations</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">All Stations</h3>
    <div class="card-tools">
      <a href="{{ route('admin.stations.create') }}" class="btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  <div class="card-body">
    <table id="stations-table"
           class="table table-striped table-bordered w-100"
           data-ajax-url="{{ route('admin.stations.index') }}"
           data-csrf-token="{{ csrf_token() }}"
           data-show-url-template="{{ route('admin.stations.show', ':id') }}"
           data-edit-url-template="{{ route('admin.stations.edit', ':id') }}"
           data-delete-url-template="{{ route('admin.stations.destroy', ':id') }}">
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>City</th>
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
<script src="{{ asset('js/admin/stations.js') }}"></script>
@endpush
