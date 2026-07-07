@extends('layouts.app')

@section('title', 'Train Detail')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Train Detail</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.trains.index') }}">Trains</a></li>
          <li class="breadcrumb-item active">{{ $train->code }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">{{ $train->name }}</span></div>
  <div class="card-body">
    <dl class="row mb-3">
      <dt class="col-sm-2">Code</dt>
      <dd class="col-sm-10"><span class="badge bg-secondary">{{ $train->code }}</span></dd>
      <dt class="col-sm-2">Status</dt>
      <dd class="col-sm-10"><span class="badge bg-{{ $train->status === 'active' ? 'success' : 'danger' }}">{{ $train->status }}</span></dd>
    </dl>

    <h5 class="mb-2">Carriages ({{ $train->carriages->count() }})</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr><th>Name</th><th>Class</th><th>Capacity</th><th>Seats</th></tr>
        </thead>
        <tbody>
          @forelse ($train->carriages as $carriage)
          <tr>
            <td>{{ $carriage->name }}</td>
            <td><span class="badge bg-info">{{ $carriage->class }}</span></td>
            <td>{{ $carriage->capacity }}</td>
            <td>{{ $carriage->seats->count() }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-secondary">No carriages.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.trains.edit', $train) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
