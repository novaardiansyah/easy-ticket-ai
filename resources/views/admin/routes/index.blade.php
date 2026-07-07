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
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="card-title">All Routes</span>
    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary btn-sm">Add New</a>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Origin</th><th>Destination</th><th>Distance (km)</th><th>Duration (min)</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($routes as $route)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $route->originStation->name ?? '-' }} <span class="badge bg-secondary">{{ $route->originStation->code ?? '' }}</span></td>
          <td>{{ $route->destinationStation->name ?? '-' }} <span class="badge bg-secondary">{{ $route->destinationStation->code ?? '' }}</span></td>
          <td>{{ $route->distance_km ? number_format($route->distance_km) : '-' }}</td>
          <td>{{ $route->estimated_duration ?? '-' }}</td>
          <td>
            <a href="{{ route('admin.routes.edit', $route) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this route?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-secondary py-3">No routes found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
