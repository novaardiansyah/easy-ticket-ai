@extends('layouts.app')

@section('title', 'Carriages')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Carriages</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Carriages</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">All Carriages</h3>
    <div class="card-tools d-flex align-items-center">
      <div class="me-2">
        <select name="train_id" class="form-select form-select-sm d-inline-block w-auto">
          <option value="">All Trains</option>
          @foreach ($trains as $t)
          <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->code }})</option>
          @endforeach
        </select>
      </div>
      <a href="{{ route('admin.carriages.create') }}" class="btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  <div class="card-body">
    <table id="carriages-table" 
           class="table table-striped table-bordered w-100"
           data-ajax-url="{{ route('admin.carriages.index') }}"
           data-csrf-token="{{ csrf_token() }}"
           data-edit-url-template="{{ route('admin.carriages.edit', ':id') }}"
           data-delete-url-template="{{ route('admin.carriages.destroy', ':id') }}">
      <thead>
        <tr>
          <th>Train</th>
          <th>Name</th>
          <th>Class</th>
          <th>Capacity</th>
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
<script src="{{ asset('js/admin/carriages.js') }}"></script>
@endpush
