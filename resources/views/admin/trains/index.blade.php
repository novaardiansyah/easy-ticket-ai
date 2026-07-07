@extends('layouts.app')

@section('title', 'Trains')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Trains</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Trains</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="card-title">All Trains</span>
    <a href="{{ route('admin.trains.create') }}" class="btn btn-primary btn-sm">Add New</a>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Code</th><th>Name</th><th>Status</th><th>Carriages</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($trains as $train)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><span class="badge bg-secondary">{{ $train->code }}</span></td>
          <td>{{ $train->name }}</td>
          <td><span class="badge bg-{{ $train->status === 'active' ? 'success' : 'danger' }}">{{ $train->status }}</span></td>
          <td>{{ $train->carriages_count }}</td>
          <td>
            <a href="{{ route('admin.trains.show', $train) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
            <a href="{{ route('admin.trains.edit', $train) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.trains.destroy', $train) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this train?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-secondary py-3">No trains found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
