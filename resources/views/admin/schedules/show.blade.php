@extends('layouts.app')

@section('title', 'Schedule Detail')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Schedule Detail</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Schedules</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">Schedule #{{ $schedule->id }}</span></div>
  <div class="card-body">
    <dl class="row mb-3">
      <dt class="col-sm-2">Train</dt>
      <dd class="col-sm-10">{{ $schedule->train->name ?? '-' }} ({{ $schedule->train->code ?? '-' }})</dd>

      <dt class="col-sm-2">Route</dt>
      <dd class="col-sm-10">{{ $schedule->route->originStation->name ?? '?' }} &rarr; {{ $schedule->route->destinationStation->name ?? '?' }}</dd>

      <dt class="col-sm-2">Departure</dt>
      <dd class="col-sm-10">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y H:i') }}</dd>

      <dt class="col-sm-2">Arrival</dt>
      <dd class="col-sm-10">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('d M Y H:i') }}</dd>

      <dt class="col-sm-2">Base Price</dt>
      <dd class="col-sm-10">Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</dd>
    </dl>

    @if ($schedule->stops->count())
    <h5 class="mb-2">Stops ({{ $schedule->stops->count() }})</h5>
    <table class="table table-bordered table-sm">
      <thead>
        <tr><th>#</th><th>Station</th><th>Arrival</th><th>Departure</th></tr>
      </thead>
      <tbody>
        @foreach ($schedule->stops->sortBy('stop_order') as $stop)
        <tr>
          <td>{{ $stop->stop_order }}</td>
          <td>{{ $stop->station->name ?? '-' }}</td>
          <td>{{ $stop->arrival_time ? \Carbon\Carbon::parse($stop->arrival_time)->format('H:i') : '-' }}</td>
          <td>{{ $stop->departure_time ? \Carbon\Carbon::parse($stop->departure_time)->format('H:i') : '-' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
