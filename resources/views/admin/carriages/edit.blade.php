@extends('layouts.app')

@section('title', 'Edit Carriage')

@section('content-header')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Edit Carriage</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.carriages.index') }}">Carriages</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header"><span class="card-title">Carriage Details</span></div>
  <div class="card-body">
    <form action="{{ route('admin.carriages.update', $carriage) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Train <span class="text-danger">*</span></label>
        <select name="train_id" class="form-select @error('train_id') is-invalid @enderror" required>
          <option value="">Select Train</option>
          @foreach ($trains as $train)
          <option value="{{ $train->id }}" {{ old('train_id', $carriage->train_id) == $train->id ? 'selected' : '' }}>{{ $train->name }} ({{ $train->code }})</option>
          @endforeach
        </select>
        @error('train_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $carriage->name) }}" maxlength="50" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Class <span class="text-danger">*</span></label>
        <select name="class" class="form-select @error('class') is-invalid @enderror" required>
          @foreach (['economy', 'business', 'executive', 'luxury'] as $cls)
          <option value="{{ $cls }}" {{ old('class', $carriage->class) === $cls ? 'selected' : '' }}>{{ ucfirst($cls) }}</option>
          @endforeach
        </select>
        @error('class')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Capacity <span class="text-danger">*</span></label>
        <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $carriage->capacity) }}" min="1" max="100" required>
        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.carriages.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
