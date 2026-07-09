@extends('layouts.landing')

@section('title', 'Pesan Tiket Kereta Api Online')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('css/landing-index.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="hero-section">
  <img src="{{ asset('images/banner/banner-5.webp') }}" class="hero-banner-img mb-4 mb-md-0" alt="Easy Ticket AI Banner">
  <div class="search-card-wrapper">
    <div class="container">
      <div class="card search-card p-4">
        <form method="POST" action="{{ route('landing.search.process') }}" id="search-form">
          @csrf
          <div class="row g-3 align-items-end">
            <div class="col-md-3">
              <label class="form-label fw-semibold small">Stasiun Asal</label>
              <select name="origin_station_id" id="origin_station_id" class="form-select select2" required>
                <option value="">Pilih Stasiun Asal</option>
                @foreach ($stations as $s)
                <option value="{{ $s->id }}" {{ (string)$originId === (string)$s->id ? 'selected' : '' }}>{{ $s->city }} - {{ $s->name }} ({{ $s->code }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold small">Stasiun Tujuan</label>
              <select name="destination_station_id" id="destination_station_id" class="form-select select2" required>
                <option value="">Pilih Stasiun Tujuan</option>
                @foreach ($stations as $s)
                <option value="{{ $s->id }}" {{ (string)$destinationId === (string)$s->id ? 'selected' : '' }}>{{ $s->city }} - {{ $s->name }} ({{ $s->code }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold small">Tanggal Keberangkatan</label>
              <input type="text" name="departure_date" id="departure_date" class="form-control bg-white" value="{{ $departureDate ?? '' }}" placeholder="Pilih Tanggal" required readonly style="background-color: #ffffff !important;">
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-search me-2"></i>Cari</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container pt-md-4">
<div class="my-5">
    <h4 class="fw-bold mb-4"><i class="bi bi-star-fill text-warning me-2"></i>Rute Favorit</h4>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body">
            <span class="badge bg-primary-subtle text-primary mb-2">Terpopuler</span>
            <h5 class="fw-bold mb-1">Jakarta &rarr; Bandung</h5>
            <p class="text-secondary small mb-3">Mulai dari Rp 150.000</p>
            <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="document.getElementById('origin_station_id').value='1'; document.getElementById('destination_station_id').value='2'; $('#origin_station_id, #destination_station_id').trigger('change');">Cari Jadwal</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body">
            <span class="badge bg-success-subtle text-success mb-2">Paling Nyaman</span>
            <h5 class="fw-bold mb-1">Bandung &rarr; Surabaya</h5>
            <p class="text-secondary small mb-3">Mulai dari Rp 320.000</p>
            <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="document.getElementById('origin_station_id').value='2'; document.getElementById('destination_station_id').value='3'; $('#origin_station_id, #destination_station_id').trigger('change');">Cari Jadwal</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body">
            <span class="badge bg-warning-subtle text-warning mb-2">Pemandangan Indah</span>
            <h5 class="fw-bold mb-1">Jakarta &rarr; Yogyakarta</h5>
            <p class="text-secondary small mb-3">Mulai dari Rp 280.000</p>
            <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="document.getElementById('origin_station_id').value='1'; document.getElementById('destination_station_id').value='4'; $('#origin_station_id, #destination_station_id').trigger('change');">Cari Jadwal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="my-5">
    <h4 class="fw-bold mb-4"><i class="bi bi-newspaper text-primary me-2"></i>Berita & Promo Terbaru</h4>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body p-0">
            <div class="bg-primary text-white p-4 text-center rounded-top" style="height: 120px; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-percent fs-1"></i>
            </div>
            <div class="p-3">
              <span class="text-primary fw-semibold small">PROMO</span>
              <h6 class="fw-bold mt-1 mb-2">Promo Liburan Akhir Pekan: Diskon Tiket Hingga 20%</h6>
              <p class="text-secondary small mb-0">Nikmati diskon khusus untuk keberangkatan hari Sabtu & Minggu selama bulan Juli.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body p-0">
            <div class="bg-success text-white p-4 text-center rounded-top" style="height: 120px; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-wallet2 fs-1"></i>
            </div>
            <div class="p-3">
              <span class="text-success fw-semibold small">PENGUMUMAN</span>
              <h6 class="fw-bold mt-1 mb-2">Integrasi Pembayaran E-Wallet Baru Kini Aktif</h6>
              <p class="text-secondary small mb-0">Pemesanan tiket kereta api kini lebih mudah dengan pembayaran instan via dompet digital.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border shadow-sm h-100">
          <div class="card-body p-0">
            <div class="bg-info text-white p-4 text-center rounded-top" style="height: 120px; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-lightbulb fs-1"></i>
            </div>
            <div class="p-3">
              <span class="text-info fw-semibold small">TIPS PERJALANAN</span>
              <h6 class="fw-bold mt-1 mb-2">Tips Perjalanan Aman & Nyaman dengan Kereta Cepat</h6>
              <p class="text-secondary small mb-0">Beberapa persiapan penting sebelum bepergian untuk menghindari antrean stasiun.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold"><i class="bi bi-ticket-perforated me-2"></i>Pemesanan Tiket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="booking-form" method="POST">
        @csrf
        <input type="hidden" name="schedule_id" id="modal-schedule-id">
        <div class="modal-body">
          <div class="alert alert-info d-flex align-items-center py-2 small">
            <i class="bi bi-info-circle me-2"></i>
            Harga per tiket: <strong class="ms-1" id="modal-base-price">Rp0</strong>
          </div>

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
            <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-passenger-modal" disabled>
              <i class="bi bi-plus-lg"></i> Tambah Penumpang
            </button>
          </div>

          <div id="passengers-container-modal"></div>

          <div class="text-end mt-4 pt-2 border-top">
            <h5 class="fw-bold">Total: <span id="total-price-modal" class="text-primary">Rp0</span></h5>
          </div>

          <h6 class="fw-semibold border-bottom pb-2 mt-4"><i class="bi bi-credit-card me-1"></i>Metode Pembayaran</h6>
          <div class="row g-3">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold" id="btn-submit-modal" disabled>
            <i class="bi bi-check-lg me-1"></i>Pesan Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<template id="passenger-template-modal">
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
          <select name="passengers[{index}][seat_id]" class="form-select form-select-sm select-seat-modal" required>
            <option value="">Pilih Kursi</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>
@endsection

@push('scripts')
<div id="landing-config"
     data-get-seats-url="{{ route('landing.get-seats') }}"
     data-bookings-store-url="{{ route('landing.bookings.store') }}"
     data-flash-success="{{ session('success') }}"></div>
<script src="{{ asset('js/landing-index.js') }}"></script>
@endpush
