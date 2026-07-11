@extends('layouts.landing')

@section('title', 'Pemesanan Tiket - Data Pemesan')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('css/landing-index.css') }}" rel="stylesheet">
<style>
  .booking-container {
    max-width: 1000px;
  }
  .step-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    position: relative;
  }
  .step-indicator::before {
    content: '';
    position: absolute;
    top: 24px;
    left: 50px;
    right: 50px;
    height: 2px;
    background-color: #e2e8f0;
    z-index: 1;
  }
  .step-indicator .step-line {
    position: absolute;
    top: 24px;
    left: 50px;
    height: 2px;
    background-color: #0d6efd;
    z-index: 2;
    transition: width 0.3s ease;
  }
  .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 3;
    flex: 1;
    color: #94a3b8;
    font-weight: 500;
    font-size: 0.8rem;
  }
  .step.active {
    color: #0d6efd;
  }
  .step.completed {
    color: #0d6efd;
  }
  .step .step-num {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
  }
  .step.active .step-num {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
  }
  .step.completed .step-num {
    background-color: #198754;
    color: #fff;
    border-color: #198754;
  }
  .step.completed .step-num i {
    display: inline-block;
  }
  .step .step-num i {
    display: none;
  }
  @media (max-width: 767.98px) {
    .step-indicator::before, .step-indicator .step-line {
      left: 24px;
      right: 24px;
    }
    .step {
      font-size: 0.7rem;
    }
    .step .step-num {
      width: 40px;
      height: 40px;
      font-size: 0.9rem;
    }
  }
  .passenger-card {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
    background: #fff;
  }
  .passenger-card .card-header {
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .passenger-card .card-header h6 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
    color: #334155;
    letter-spacing: -0.015em;
  }
  .passenger-card .card-body {
    padding: 1rem;
  }
  .passenger-card .form-label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.4rem;
  }
  .passenger-card .form-control, .passenger-card .form-select {
    font-size: 0.9rem;
    border-color: #e2e8f0;
    padding: 0.5rem 0.75rem;
  }
  .btn-remove-passenger {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s ease;
  }
  .btn-remove-passenger:hover {
    background-color: #fee;
    transform: scale(1.1);
  }
  .btn-remove-passenger:disabled {
    opacity: 0.3;
    cursor: not-allowed;
  }
  .seat-select {
    cursor: pointer;
  }
</style>
@endpush

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="booking-container mx-auto">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="fw-bold mb-0"><i class="bi bi-ticket-perforated me-2"></i>Pemesanan Tiket</h4>
          <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
        </div>

        <!-- Schedule Summary Card -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-4">
                <div class="fw-bold fs-5">{{ $schedule->train->name }} ({{ $schedule->train->code }})</div>
                <div class="small text-secondary">
                  {{ $schedule->route->originStation->city }} ({{ $schedule->route->originStation->code }})
                  <i class="bi bi-arrow-right mx-2"></i>
                  {{ $schedule->route->destinationStation->city }} ({{ $schedule->route->destinationStation->code }})
                </div>
              </div>
              <div class="col-md-4">
                <div class="d-flex justify-content-center align-items-center small">
                  <div class="text-center">
                    <div class="fw-semibold">
                      {{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y') }}
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem; line-height: 1.2;">
                      {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H.i') }} WIB
                    </div>
                  </div>
                  <div class="text-muted px-3">&rarr;</div>
                  <div class="text-center">
                    <div class="fw-semibold">
                      {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('d M Y') }}
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem; line-height: 1.2;">
                      {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H.i') }} WIB
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 text-md-end">
                <span class="fw-bold text-primary fs-5">{{ formatRupiah($schedule->base_price) }}</span>
                <div class="small text-secondary">per tiket</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Step Indicator -->
        <div class="mb-4">
          <div class="step-indicator" id="step-indicator">
            <div class="step-line" id="step-line"></div>
            <div class="step active" data-step="1">
              <span class="step-num">1</span>
              <span>Data Pemesan & Penumpang</span>
            </div>
            <div class="step" data-step="2">
              <span class="step-num">2</span>
              <span>Pembayaran</span>
            </div>
            <div class="step" data-step="3">
              <span class="step-num">3</span>
              <span>Konfirmasi</span>
            </div>
          </div>
        </div>

        <!-- Form -->
        <form id="booking-form" method="POST" action="{{ route('landing.bookings.step1.process') }}">
          @csrf
          <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

          @error('passengers')
            <div class="alert alert-danger py-2 small mb-3">{{ $message }}</div>
          @enderror

          <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

              <!-- Customer Data -->
              <h6 class="fw-semibold border-bottom pb-2 mb-4"><i class="bi bi-person me-1"></i>Data Pemesan</h6>
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label small">Nama Lengkap<span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" placeholder="Nama pemesan" value="{{ old('customer_name', session('booking_step1.customer_name')) }}" required>
                  @error('customer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label small">Email<span class="text-danger">*</span></label>
                  <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" placeholder="email@example.com" value="{{ old('customer_email', session('booking_step1.customer_email')) }}" required>
                  @error('customer_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label small">No. Telepon<span class="text-danger">*</span></label>
                  <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" placeholder="08xx" value="{{ old('customer_phone', session('booking_step1.customer_phone')) }}" required>
                  @error('customer_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Passengers -->
              <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h6 class="fw-semibold mb-0"><i class="bi bi-people me-1"></i>Penumpang</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-passenger">
                  <i class="bi bi-plus-lg"></i> Tambah Penumpang
                </button>
              </div>

              <div id="passengers-container"></div>

              <div class="text-end mt-4 pt-3 border-top">
                <h5 class="fw-bold mb-0">Total: <span id="total-price" class="text-primary">Rp0</span></h5>
              </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-end">
              <button type="submit" class="btn btn-primary px-4">
                Selanjutnya<i class="bi bi-arrow-right ms-1"></i>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Passenger Template -->
<template id="passenger-template">
  <div class="passenger-card" data-index="{index}">
    <div class="card-header">
      <h6 class="mb-0">Penumpang #{number}</h6>
      <button type="button" class="btn-remove-passenger" aria-label="Hapus" title="Hapus penumpang">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label small">Nama Penumpang<span class="text-danger">*</span></label>
          <input type="text" name="passengers[{index}][passenger_name]" class="form-control form-control-sm" placeholder="Nama sesuai identitas" required>
          <div class="invalid-feedback"></div>
        </div>
        <div class="col-md-2">
          <label class="form-label small">Jenis ID<span class="text-danger">*</span></label>
          <select name="passengers[{index}][passenger_id_type]" class="form-select form-select-sm" required>
            <option value="ktp">KTP</option>
            <option value="passport">Paspor</option>
            <option value="sim">SIM</option>
          </select>
          <div class="invalid-feedback"></div>
        </div>
        <div class="col-md-3">
          <label class="form-label small">No. ID<span class="text-danger">*</span></label>
          <input type="text" name="passengers[{index}][passenger_id_number]" class="form-control form-control-sm" placeholder="Nomor identitas" required>
          <div class="invalid-feedback"></div>
        </div>
        <div class="col-md-3">
          <label class="form-label small">Kursi<span class="text-danger">*</span></label>
          <select name="passengers[{index}][seat_id]" class="form-select form-select-sm seat-select" required>
            <option value="">Pilih Kursi</option>
          </select>
          <div class="invalid-feedback"></div>
        </div>
      </div>
    </div>
  </div>
</template>
@endsection

@push('scripts')
<div id="booking-config"
     data-get-seats-url="{{ route('landing.get-seats') }}"
     data-schedule-id="{{ $schedule->id }}"
     data-base-price="{{ $schedule->base_price }}"
     data-old-passengers='@json(old('passengers', []))'
     data-errors='@json($errors->toArray())'></div>
<script src="{{ asset('js/booking-step1.js') }}"></script>
@endpush