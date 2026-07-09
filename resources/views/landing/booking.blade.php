@extends('layouts.landing')

@section('title', 'Pemesanan Tiket')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('css/landing-index.css') }}" rel="stylesheet">
<style>
  .step-indicator {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 1.5rem;
  }
  .step {
    display: flex;
    align-items: center;
    color: #94a3b8;
    font-weight: 600;
    font-size: 0.85rem;
  }
  .step .step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #94a3b8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    font-weight: 700;
  }
  .step.active .step-num,
  .step.done .step-num {
    background: #0d6efd;
    color: #fff;
  }
  .step.active,
  .step.done {
    color: #0d6efd;
  }
  .step-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 12px;
  }
  .step-line.done {
    background: #0d6efd;
  }
  .step-pane { display: none; }
  .step-pane.active { display: block; }
  .summary-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #e2e8f0;
  }
</style>
@endpush

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-ticket-perforated me-2"></i>Pemesanan Tiket</h4>
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
      </div>

      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-3">
          <div class="row align-items-center g-2">
            <div class="col-md-7">
              <div class="fw-bold">{{ $schedule->train->name }} ({{ $schedule->train->code }})</div>
              <div class="small text-secondary">
                {{ $schedule->route->originStation->city }} ({{ $schedule->route->originStation->code }})
                <i class="bi bi-arrow-right mx-1"></i>
                {{ $schedule->route->destinationStation->city }} ({{ $schedule->route->destinationStation->code }})
              </div>
            </div>
            <div class="col-md-3 small text-secondary">
              <i class="bi bi-calendar3 me-1"></i>
              {{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y') }}
              <span class="ms-2"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</span>
            </div>
            <div class="col-md-2 text-md-end">
              <span class="fw-bold text-primary">{{ formatRupiah($schedule->base_price) }}</span>
              <div class="small text-secondary">per tiket</div>
            </div>
          </div>
        </div>
      </div>

      <div class="step-indicator">
        <div class="step active" data-step="1">
          <span class="step-num">1</span>
          <span>Data Pemesan & Penumpang</span>
        </div>
        <div class="step-line" data-line="1"></div>
        <div class="step" data-step="2">
          <span class="step-num">2</span>
          <span>Pembayaran</span>
        </div>
      </div>

      <form id="booking-form" method="POST" action="{{ route('landing.bookings.store') }}">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

        <div class="card border-0 shadow-sm">
          <div class="card-body">

            <div class="step-pane active" data-pane="1">
              <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-person me-1"></i>Data Pemesan</h6>
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label small">Nama Lengkap</label>
                  <input type="text" name="customer_name" class="form-control" placeholder="Nama pemesan" required>
                </div>
                <div class="col-md-3">
                  <label class="form-label small">Email</label>
                  <input type="email" name="customer_email" class="form-control" placeholder="email@example.com" required>
                </div>
                <div class="col-md-3">
                  <label class="form-label small">No. Telepon</label>
                  <input type="text" name="customer_phone" class="form-control" placeholder="08xx" required>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h6 class="fw-semibold mb-0"><i class="bi bi-people me-1"></i>Penumpang</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-passenger">
                  <i class="bi bi-plus-lg"></i> Tambah Penumpang
                </button>
              </div>

              <div id="passengers-container"></div>

              <div class="text-end mt-4 pt-2 border-top">
                <h5 class="fw-bold mb-0">Total: <span id="total-price" class="text-primary">Rp0</span></h5>
              </div>
            </div>

            <div class="step-pane" data-pane="2">
              <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-credit-card me-1"></i>Metode Pembayaran</h6>
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <div class="form-check card p-3 border payment-option">
                    <input class="form-check-input" type="radio" name="payment_method" id="pay-bank" value="bank_transfer" checked>
                    <label class="form-check-label w-100" for="pay-bank">
                      <i class="bi bi-bank me-1"></i> Bank Transfer
                      <span class="d-block small text-secondary mt-1">Transfer ke rekening kami</span>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check card p-3 border payment-option">
                    <input class="form-check-input" type="radio" name="payment_method" id="pay-ewallet" value="ewallet">
                    <label class="form-check-label w-100" for="pay-ewallet">
                      <i class="bi bi-wallet2 me-1"></i> E-Wallet
                      <span class="d-block small text-secondary mt-1">Bayar via dompet digital</span>
                    </label>
                  </div>
                </div>
              </div>

              <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-receipt me-1"></i>Ringkasan Pesanan</h6>
              <div class="summary-card">
                <div class="d-flex justify-content-between small mb-1">
                  <span>Kereta</span>
                  <span class="fw-semibold">{{ $schedule->train->name }} ({{ $schedule->train->code }})</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                  <span>Rute</span>
                  <span class="fw-semibold">{{ $schedule->route->originStation->code }} → {{ $schedule->route->destinationStation->code }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                  <span>Keberangkatan</span>
                  <span class="fw-semibold">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                  <span>Jumlah Penumpang</span>
                  <span class="fw-semibold" id="summary-passenger-count">1</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                  <span class="fw-semibold">Total Bayar</span>
                  <span class="fw-bold text-primary" id="summary-total">Rp0</span>
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer bg-white d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="btn-prev" disabled>
              <i class="bi bi-arrow-left me-1"></i>Sebelumnya
            </button>
            <button type="button" class="btn btn-primary" id="btn-next">
              Selanjutnya<i class="bi bi-arrow-right ms-1"></i>
            </button>
            <button type="submit" class="btn btn-primary fw-bold d-none" id="btn-submit">
              <i class="bi bi-check-lg me-1"></i>Pesan Sekarang
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<template id="passenger-template">
  <div class="card card-outline card-secondary mb-2 passenger-row" data-index="{index}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
      <span class="fw-semibold small">Penumpang #{number}</span>
      <button type="button" class="btn-close btn-remove-passenger" aria-label="Hapus"></button>
    </div>
    <div class="card-body py-2">
      <div class="row g-2">
        <div class="col-md-4">
          <label class="form-label small">Nama Penumpang</label>
          <input type="text" name="passengers[{index}][passenger_name]" class="form-control form-control-sm" placeholder="Nama sesuai identitas" required>
        </div>
        <div class="col-md-2">
          <label class="form-label small">Jenis ID</label>
          <select name="passengers[{index}][passenger_id_type]" class="form-select form-select-sm" required>
            <option value="ktp">KTP</option>
            <option value="passport">Paspor</option>
            <option value="sim">SIM</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label small">No. ID</label>
          <input type="text" name="passengers[{index}][passenger_id_number]" class="form-control form-control-sm" placeholder="Nomor identitas" required>
        </div>
        <div class="col-md-3">
          <label class="form-label small">Kursi</label>
          <select name="passengers[{index}][seat_id]" class="form-select form-select-sm select-seat" required>
            <option value="">Pilih Kursi</option>
          </select>
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
     data-base-price="{{ $schedule->base_price }}"></div>
<script src="{{ asset('js/booking.js') }}"></script>
@endpush
