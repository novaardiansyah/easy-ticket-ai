@extends('layouts.app')

@section('title', 'Routes')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Routes</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Routes</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">All Routes</h3>
    <div class="card-tools">
      <a href="{{ route('admin.routes.create') }}" class="btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  <div class="card-body">
    <table id="routes-table" 
           class="table table-striped table-bordered w-100"
           data-ajax-url="{{ route('admin.routes.index') }}"
           data-csrf-token="{{ csrf_token() }}"
           data-edit-url-template="{{ route('admin.routes.edit', ':id') }}"
           data-delete-url-template="{{ route('admin.routes.destroy', ':id') }}">
      <thead>
        <tr>
          <th>Origin</th>
          <th>Destination</th>
          <th>Distance (km)</th>
          <th>Duration (min)</th>
          <th style="width: 120px;">Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('styles')
<style>
  div.dataTables_wrapper div.dataTables_processing {
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
  }
  table.dataTable {
    margin-top: 15px !important;
    margin-bottom: 15px !important;
  }
  .dropdown-menu {
    z-index: 1050 !important;
  }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/admin/routes.js') }}"></script>
@endpush
