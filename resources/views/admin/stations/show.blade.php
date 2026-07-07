@extends('layouts.app')

@section('title', 'Station Detail')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Station Detail</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.stations.index') }}">Stations</a></li>
          <li class="breadcrumb-item active">{{ $station->code }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-2">Code</dt>
      <dd class="col-sm-10"><span class="badge bg-secondary">{{ $station->code }}</span></dd>

      <dt class="col-sm-2">Name</dt>
      <dd class="col-sm-10">{{ $station->name }}</dd>

      <dt class="col-sm-2">City</dt>
      <dd class="col-sm-10">{{ $station->city }}</dd>

      <dt class="col-sm-2">Address</dt>
      <dd class="col-sm-10">{{ $station->address ?: '-' }}</dd>

      <dt class="col-sm-2">Created</dt>
      <dd class="col-sm-10">{{ $station->created_at->format('d M Y H:i') }}</dd>

      <dt class="col-sm-2">Updated</dt>
      <dd class="col-sm-10">{{ $station->updated_at->format('d M Y H:i') }}</dd>
    </dl>
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.stations.edit', $station) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
