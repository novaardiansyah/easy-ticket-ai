@extends('layouts.landing')

@section('title', 'Pemesanan Tiket - Pembayaran')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('css/landing-index.css') }}" rel="stylesheet">
<style>
  .booking-container {
    max-width: 1000px;
  }
  .payment-option {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
  }
  .payment-option:hover {
    border-color: #cbd5e1;
  }
  .payment-option.selected {
    border-color: #0d6efd;
    background-color: #f0f7ff;
  }
  .payment-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }
  .payment-option .payment-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
  }
  .payment-option .payment-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
  }
  .payment-option .payment-info {
    flex: 1;
  }
  .payment-option .payment-name {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
  }
  .payment-option .payment-desc {
    font-size: 0.85rem;
    color: #64748b;
  }
  .schedule-summary {
    background: #f8fafc;
    border-radius: 8px;
    padding: 1rem;
  }
  .schedule-summary .summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.9rem;
  }
  .schedule-summary .summary-row:last-child {
    border-bottom: none;
  }
  .schedule-summary .summary-label {
    color: #64748b;
    font-weight: 500;
  }
  .schedule-summary .summary-value {
    font-weight: 600;
    color: #1e293b;
    text-align: right;
  }
  .schedule-summary .summary-total {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0d6efd;
  }
  .passengers-list {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
  }
  .passenger-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.9rem;
    border-bottom: 1px solid #f1f5f9;
  }
  .passenger-item:last-child {
    border-bottom: none;
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
          <a href="{{ route('landing.bookings.step1', ['data' => request('data')]) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
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
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-primary" style="width: 50%"></div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <small class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Step 1: Data Pemesan & Penumpang</small>
            <small class="fw-semibold text-primary">Step 2: Pembayaran</small>
            <small class="text-muted">Step 3: Konfirmasi</small>
          </div>
        </div>

        <!-- Form -->
        <form id="booking-form" method="POST" action="{{ route('landing.bookings.step2.process') }}">
          @csrf

          <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

              <!-- Payment Method -->
              <h6 class="fw-semibold border-bottom pb-2 mb-4"><i class="bi bi-credit-card me-1"></i>Metode Pembayaran</h6>
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <div class="payment-option selected" data-method="bank_transfer">
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

              <!-- Order Summary -->
              <h6 class="fw-semibold border-bottom pb-2 mb-3"><i class="bi bi-receipt me-1"></i>Ringkasan Pesanan</h6>
              
              <!-- Customer Info -->
              <div class="mb-3">
                <strong class="d-block mb-2">Data Pemesan:</strong>
                <div class="small text-secondary">
                  <div>{{ $bookingData['customer_name'] }}</div>
                  <div>{{ $bookingData['customer_email'] }} | {{ $bookingData['customer_phone'] }}</div>
                </div>
              </div>

              <!-- Passengers List -->
              <div class="mb-3">
                <strong class="d-block mb-2">Daftar Penumpang:</strong>
                <div class="passengers-list">
                  @foreach($bookingData['passengers'] as $index => $passenger)
                  <div class="passenger-item">
                    <span>{{ $index + 1 }}. {{ $passenger['passenger_name'] }}</span>
                    <span class="text-muted">{{ $passenger['seat_number'] }}</span>
                  </div>
                  @endforeach
                </div>
              </div>

              <!-- Summary -->
              <div class="schedule-summary">
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
                  <span class="summary-value">{{ count($bookingData['passengers']) }}</span>
                </div>
                <div class="summary-row">
                  <span class="summary-label">Harga per Tiket</span>
                  <span class="summary-value">{{ formatRupiah($schedule->base_price) }}</span>
                </div>
                <div class="summary-row">
                  <span class="summary-label summary-total">Total Bayar</span>
                  <span class="summary-value summary-total">{{ formatRupiah($schedule->base_price * count($bookingData['passengers'])) }}</span>
                </div>
              </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-between">
              <a href="{{ route('landing.bookings.step1', ['data' => request('data')]) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Sebelumnya
              </a>
              <button type="submit" class="btn btn-primary px-4" id="btn-submit">
                <i class="bi bi-check-lg me-1"></i>Pesan Sekarang
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/booking-step2.js') }}"></script>
@endpush
