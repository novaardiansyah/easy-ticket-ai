@extends('layouts.app')

@section('title', 'Schedules')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Schedules</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Schedules</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="card-title">All Schedules</span>
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary btn-sm">Add New</a>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>#</th><th>Train</th><th>Route</th><th>Departure</th><th>Arrival</th><th>Base Price</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($schedules as $schedule)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $schedule->train->name ?? '-' }}</td>
          <td>
            {{ $schedule->route->originStation->code ?? '?' }}
            &rarr;
            {{ $schedule->route->destinationStation->code ?? '?' }}
          </td>
          <td>{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y H:i') }}</td>
          <td>{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('d M Y H:i') }}</td>
          <td>Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</td>
          <td>
            <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-secondary py-3">No schedules found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
