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
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="card-title">All Stations</span>
    <a href="{{ route('admin.stations.create') }}" class="btn btn-primary btn-sm">Add New</a>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>City</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($stations as $station)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><span class="badge bg-secondary">{{ $station->code }}</span></td>
          <td>{{ $station->name }}</td>
          <td>{{ $station->city }}</td>
          <td>
            <a href="{{ route('admin.stations.show', $station) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
            <a href="{{ route('admin.stations.edit', $station) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.stations.destroy', $station) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this station?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-secondary py-3">No stations found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
