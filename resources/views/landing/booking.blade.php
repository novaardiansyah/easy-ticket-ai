@extends('layouts.landing')

@section('title', 'Pemesanan Tiket')

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
  .step-pane {
    display: none;
  }
  .step-pane.active {
    display: block;
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
    padding: 0.75rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .passenger-card .card-header h6 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
  }
  .passenger-card .card-body {
    padding: 1rem;
  }
  .passenger-card .form-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #475569;
    margin-bottom: 0.25rem;
  }
  .passenger-card .form-control,
  .passenger-card .form-select {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
  }
  .btn-remove-passenger {
    width: 28px;
    height: 28px;
    padding: 0;
    font-size: 0.75rem;
    background-color: #fee2e2;
    color: #ef4444;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }
  .btn-remove-passenger:hover {
    background-color: #ef4444;
    color: #fff;
  }
  .btn-remove-passenger:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  .seat-select {
    min-height: 44px;
  }
  .schedule-summary {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.25rem;
  }
  .schedule-summary .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.875rem;
  }
  .schedule-summary .summary-row:last-child {
    border-bottom: none;
  }
  .schedule-summary .summary-label {
    color: #64748b;
    font-weight: 500;
  }
  .schedule-summary .summary-value {
    color: #1e293b;
    font-weight: 600;
    text-align: right;
  }
  .schedule-summary .summary-total {
    font-size: 1rem;
    font-weight: 700;
    color: #0d6efd;
  }
  .payment-option {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s;
  }
  .payment-option:hover {
    border-color: #0d6efd;
  }
  .payment-option.selected {
    border-color: #0d6efd;
    background-color: #eff6ff;
  }
  .payment-option input[type="radio"] {
    width: 1.125rem;
    height: 1.125rem;
    accent-color: #0d6efd;
  }
  .payment-option .payment-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
  }
  .payment-option .payment-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }
  .payment-option .payment-info {
    flex: 1;
  }
  .payment-option .payment-name {
    font-weight: 600;
    font-size: 0.875rem;
    color: #1e293b;
  }
  .payment-option .payment-desc {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.25rem;
  }
  .btn-nav {
    min-width: 140px;
  }
  @media (max-width: 767.98px) {
    .step-indicator::before,
    .step-indicator .step-line {
      display: none;
    }
    .step {
      font-size: 0.7rem;
    }
    .step .step-num {
      width: 36px;
      height: 36px;
      font-size: 0.875rem;
    }
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

        <form id="booking-form" method="POST" action="{{ route('landing.bookings.store') }}">
          @csrf
          <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

          <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

              <div class="step-pane active" data-pane="1">
                <h6 class="fw-semibold border-bottom pb-2 mb-4"><i class="bi bi-person me-1"></i>Data Pemesan</h6>
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

                <div class="text-end mt-4 pt-3 border-top">
                  <h5 class="fw-bold mb-0">Total: <span id="total-price" class="text-primary">Rp0</span></h5>
                </div>
              </div>

              <div class="step-pane" data-pane="2">
                <h6 class="fw-semibold border-bottom pb-2 mb-4"><i class="bi bi-credit-card me-1"></i>Metode Pembayaran</h6>
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <div class="payment-option" data-method="bank_transfer">
                      <input class="form-check-input visually-hidden" type="radio" name="payment_method" id="pay-bank" value="bank_transfer" checked>
                      <label class="payment-label w-100" for="pay-bank">
                        <span class="payment-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-bank"></i></span>
                        <div class="payment-info">
                          <div class="payment-name">Bank Transfer</div>
                          <div class="payment-desc">Transfer ke rekening kami</div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="payment-option" data-method="ewallet">
                      <input class="form-check-input visually-hidden" type="radio" name="payment_method" id="pay-ewallet" value="ewallet">
                      <label class="payment-label w-100" for="pay-ewallet">
                        <span class="payment-icon bg-success bg-opacity-10 text-success"><i class="bi bi-wallet2"></i></span>
                        <div class="payment-info">
                          <div class="payment-name">E-Wallet</div>
                          <div class="payment-desc">Bayar via dompet digital</div>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>

                <h6 class="fw-semibold border-bottom pb-2 mb-3"><i class="bi bi-receipt me-1"></i>Ringkasan Pesanan</h6>
                <div class="schedule-summary" id="schedule-summary">
                  <div class="summary-row">
                    <span class="summary-label">Kereta</span>
                    <span class="summary-value">{{ $schedule->train->name }} ({{ $schedule->train->code }})</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Rute</span>
                    <span class="summary-value">{{ $schedule->route->originStation->code }} &rarr; {{ $schedule->route->destinationStation->code }}</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Keberangkatan</span>
                    <span class="summary-value">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y H.i') }} WIB</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Estimasi Tiba</span>
                    <span class="summary-value">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('d M Y H.i') }} WIB</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Jumlah Penumpang</span>
                    <span class="summary-value" id="summary-passenger-count">0</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Harga per Tiket</span>
                    <span class="summary-value">{{ formatRupiah($schedule->base_price) }}</span>
                  </div>
                  <div class="summary-row">
                    <span class="summary-label summary-total">Total Bayar</span>
                    <span class="summary-value summary-total" id="summary-total">Rp0</span>
                  </div>
                </div>
              </div>

              <div class="step-pane" data-pane="3">
                <div class="text-center py-5">
                  <div class="fs-1 text-success mb-3"><i class="bi bi-check-circle-fill"></i></div>
                  <h4 class="fw-bold mb-3">Pemesanan Berhasil!</h4>
                  <p class="text-secondary mb-4">Tiket kereta api Anda sedang diproses.</p>

                  <div class="card border-0 shadow-sm mx-auto" style="max-width: 500px;">
                    <div class="card-body p-4">
                      <div class="text-center mb-4">
                        <p class="mb-1 opacity-75 small">KODE BOOKING</p>
                        <h2 class="fw-bold mb-0" id="confirm-booking-code" style="letter-spacing: 3px; font-size: 1.8rem;"></h2>
                      </div>

                      <div id="confirm-pending" class="alert alert-warning small d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle me-2 fs-5"></i>
                        <span>Status pembayaran: <strong>PENDING</strong>. Silakan transfer sesuai total tagihan dalam 2 jam.</span>
                      </div>
                      <div id="confirm-paid" class="alert alert-success d-flex align-items-center d-none">
                        <i class="bi bi-check-circle me-2 fs-5"></i>
                        <span>Status pembayaran: <strong>LUNAS</strong>. Terima kasih!</span>
                      </div>

                      <hr>

                      <div class="small mb-2">
                        <div class="d-flex justify-content-between"><span class="text-secondary">Nama Pemesan</span> <span class="fw-semibold" id="confirm-customer-name"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Email</span> <span id="confirm-customer-email"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Telepon</span> <span id="confirm-customer-phone"></span></div>
                      </div>

                      <hr>

                      <div class="small mb-2">
                        <div class="d-flex justify-content-between"><span class="text-secondary">Kereta</span> <span class="fw-semibold" id="confirm-train"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Rute</span> <span id="confirm-route"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Keberangkatan</span> <span id="confirm-departure"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Estimasi Tiba</span> <span id="confirm-arrival"></span></div>
                      </div>

                      <hr>

                      <div class="small mb-2">
                        <table class="table table-sm table-bordered" id="confirm-passengers-table">
                          <thead class="table-light">
                            <tr><th>Nama</th><th>Kursi</th><th>No. Tiket</th></tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>

                      <hr>

                      <div class="small">
                        <div class="d-flex justify-content-between"><span class="text-secondary">Metode Pembayaran</span> <span class="fw-semibold" id="confirm-payment-method"></span></div>
                        <div class="d-flex justify-content-between"><span class="text-secondary">Total Bayar</span> <span class="fw-bold fs-5 text-primary" id="confirm-total"></span></div>
                      </div>

                      <div id="confirm-bank-info" class="mt-3">
                        <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-bank me-1"></i>Instruksi Bank Transfer</h6>
                        <div class="bg-light rounded p-2 mb-2 small d-flex justify-content-between align-items-center">
                          <div><small class="text-secondary d-block">Bank BCA</small><span class="fw-bold">123-456-7890</span></div>
                          <small class="text-secondary">a.n. PT Easy Ticket AI</small>
                        </div>
                        <div class="bg-light rounded p-2 mb-2 small d-flex justify-content-between align-items-center">
                          <div><small class="text-secondary d-block">Bank Mandiri</small><span class="fw-bold">123-456-7890</span></div>
                          <small class="text-secondary">a.n. PT Easy Ticket AI</small>
                        </div>
                        <div class="bg-light rounded p-2 small d-flex justify-content-between align-items-center">
                          <div><small class="text-secondary d-block">Bank BRI</small><span class="fw-bold">123-456-7890</span></div>
                          <small class="text-secondary">a.n. PT Easy Ticket AI</small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="text-center mt-4">
                    <a href="{{ route('landing') }}" class="btn btn-primary"><i class="bi bi-house me-1"></i>Kembali ke Beranda</a>
                  </div>
                </div>
              </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-between">
              <button type="button" class="btn btn-secondary btn-nav" id="btn-prev" disabled><i class="bi bi-arrow-left me-1"></i>Sebelumnya</button>
              <div>
                <button type="button" class="btn btn-primary btn-nav me-2 d-none" id="btn-next">Selanjutnya<i class="bi bi-arrow-right ms-1"></i></button>
                <button type="submit" class="btn btn-primary fw-bold btn-nav d-none" id="btn-submit"><i class="bi bi-check-lg me-1"></i>Pesan Sekarang</button>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

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
          <select name="passengers[{index}][seat_id]" class="form-select form-select-sm seat-select" required>
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
<script src="{{ asset('js/booking.js' . '?v1.1') }}"></script>
@endpush
