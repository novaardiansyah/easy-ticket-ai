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
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="card-title">All Carriages</span>
    <div>
      <form method="GET" class="d-inline-block">
        <select name="train_id" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
          <option value="">All Trains</option>
          @foreach ($trains as $t)
          <option value="{{ $t->id }}" {{ request('train_id') == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->code }})</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('admin.carriages.create') }}" class="btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Train</th><th>Name</th><th>Class</th><th>Capacity</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($carriages as $carriage)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $carriage->train->name ?? '-' }}</td>
          <td>{{ $carriage->name }}</td>
          <td><span class="badge bg-info">{{ $carriage->class }}</span></td>
          <td>{{ $carriage->capacity }}</td>
          <td>
            <a href="{{ route('admin.carriages.edit', $carriage) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.carriages.destroy', $carriage) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this carriage?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-secondary py-3">No carriages found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
