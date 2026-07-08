@extends('layouts.landing')

@section('title', 'Pesan Tiket Kereta Api Online')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
  .hero-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    min-height: 420px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }
  .hero-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('{{ asset("images/banner/banner-1.png") }}') center/cover no-repeat;
    opacity: 0.15;
  }
  .hero-content { position: relative; z-index: 1; }
  .search-card {
    margin-top: -60px;
    position: relative;
    z-index: 2;
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
  }
  .schedule-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 12px;
  }
  .schedule-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }
  .seat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 6px;
    max-width: 300px;
  }
  .seat-item {
    aspect-ratio: 3/4;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.15s;
  }
  .seat-available {
    background: #e8f5e9;
    color: #2e7d32;
    border-color: #a5d6a7;
  }
  .seat-available:hover { background: #c8e6c9; }
  .seat-booked {
    background: #ffebee;
    color: #c62828;
    border-color: #ef9a9a;
    cursor: not-allowed;
    opacity: 0.6;
  }
  .seat-selected {
    background: #1565c0;
    color: #fff;
    border-color: #0d47a1;
  }
  .passenger-badge {
    background: #e3f2fd;
    border-radius: 20px;
    padding: 2px 12px;
    font-size: 0.8rem;
  }
</style>
@endpush

@section('content')
<div class="hero-section">
  <div class="container hero-content text-center text-white py-5">
    <h1 class="display-5 fw-bold mb-3">Perjalanan Anda Dimulai di Sini</h1>
    <p class="lead mb-0">Pesan tiket kereta api dengan mudah, cepat, dan aman.</p>
  </div>
</div>

<div class="container">
  <div class="card search-card p-4">
    <form method="GET" action="{{ route('landing') }}" id="search-form">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label fw-semibold small">Stasiun Asal</label>
          <select name="origin_station_id" id="origin_station_id" class="form-select select2" required>
            <option value="">Pilih Stasiun Asal</option>
            @foreach ($stations as $s)
            <option value="{{ $s->id }}" {{ (string)$originId === (string)$s->id ? 'selected' : '' }}>{{ $s->city }} - {{ $s->name }} ({{ $s->code }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
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
          <input type="date" name="departure_date" class="form-control" value="{{ $departureDate ?? '' }}" min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
        </div>
      </div>
    </form>
  </div>

  @if ($schedules->isNotEmpty())
  <div class="mt-5">
    <h4 class="fw-bold mb-4">
      <i class="bi bi-calendar-check me-2"></i>
      {{ $schedules->count() }} Jadwal Ditemukan
    </h4>
    <div class="row g-4">
      @foreach ($schedules as $schedule)
      <div class="col-lg-6">
        <div class="card schedule-card border shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <h5 class="fw-bold mb-1">{{ $schedule->train->name }} ({{ $schedule->train->code }})</h5>
                <span class="badge bg-secondary">{{ $schedule->train->status }}</span>
              </div>
              <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</h4>
            </div>
            <div class="row align-items-center">
              <div class="col-4 text-center">
                <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</div>
                <div class="small text-secondary">{{ $schedule->route->originStation->city }}</div>
                <div class="small text-secondary">{{ $schedule->route->originStation->code }}</div>
              </div>
              <div class="col-4 text-center">
                <div class="small text-secondary">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y') }}</div>
                <div class="my-1"><i class="bi bi-arrow-right fs-5"></i></div>
                <div class="small text-secondary">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('d M Y H:i') }}</div>
              </div>
              <div class="col-4 text-center">
                <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}</div>
                <div class="small text-secondary">{{ $schedule->route->destinationStation->city }}</div>
                <div class="small text-secondary">{{ $schedule->route->destinationStation->code }}</div>
              </div>
            </div>
            <button type="button" class="btn btn-primary w-100 mt-3 btn-book" data-schedule-id="{{ $schedule->id }}" data-base-price="{{ $schedule->base_price }}">
              <i class="bi bi-ticket-perforated me-1"></i>Pesan Tiket
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @elseif ($originId && $destinationId && $departureDate)
  <div class="text-center py-5 mt-4">
    <i class="bi bi-search text-secondary" style="font-size: 3rem;"></i>
    <h5 class="mt-3 text-secondary">Tidak ada jadwal tersedia</h5>
    <p class="text-secondary">Coba cari dengan stasiun atau tanggal lain.</p>
  </div>
  @endif
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
            Harga per tiket: <strong class="ms-1" id="modal-base-price">Rp 0</strong>
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
            <h5 class="fw-bold">Total: <span id="total-price-modal" class="text-primary">Rp 0</span></h5>
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
<script>
  let carriagesData = [];
  let passengerIndex = 0;
  let basePrice = 0;

  function formatRupiah(val) {
    return 'Rp ' + Number(val).toLocaleString('id-ID');
  }

  function populateSeatsDropdown($select) {
    $select.empty().append('<option value="">Pilih Kursi</option>');
    carriagesData.forEach(function(carriage) {
      var $group = $('<optgroup>').attr('label', carriage.name + ' (' + carriage.class + ')');
      carriage.seats.forEach(function(seat) {
        var $option = $('<option>')
          .val(seat.id)
          .text(seat.seat_number + (seat.is_available ? '' : ' (Terpesan)'))
          .prop('disabled', !seat.is_available);
        $group.append($option);
      });
      $select.append($group);
    });
  }

  function addPassengerRowModal() {
    passengerIndex++;
    var num = $('#passengers-container-modal').find('.passenger-row').length + 1;
    var html = $('#passenger-template-modal').html()
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    var $row = $(html);
    $('#passengers-container-modal').append($row);
    populateSeatsDropdown($row.find('.select-seat-modal'));
    updateTotalModal();
    toggleRemoveModal();
  }

  function toggleRemoveModal() {
    var $rows = $('#passengers-container-modal').find('.passenger-row');
    $rows.length <= 1 ? $rows.find('.btn-remove-passenger').hide() : $rows.find('.btn-remove-passenger').show();
  }

  function updateTotalModal() {
    var count = $('#passengers-container-modal').find('.passenger-row').length;
    $('#total-price-modal').text(formatRupiah(count * basePrice));
  }

  $(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

    $('#destination_station_id').on('change', function() {
      var val = $(this).val();
      $('#origin_station_id option').each(function() {
        if ($(this).val() === val) {
          $('#destination_station_id').val('').trigger('change');
          Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Stasiun tujuan tidak boleh sama dengan stasiun asal.',
            timer: 2000,
            showConfirmButton: false
          });
          return false;
        }
      });
    });

    $(document).on('click', '.btn-book', function() {
      var scheduleId = $(this).data('schedule-id');
      basePrice = $(this).data('base-price');
      $('#modal-schedule-id').val(scheduleId);
      $('#modal-base-price').text(formatRupiah(basePrice));
      $('#passengers-container-modal').empty();
      passengerIndex = 0;
      $('#total-price-modal').text(formatRupiah(0));
      $('#btn-add-passenger-modal').prop('disabled', true);
      $('#btn-submit-modal').prop('disabled', true);

      $.ajax({
        url: '{{ route("landing.get-seats") }}',
        type: 'GET',
        data: { schedule_id: scheduleId },
        success: function(data) {
          carriagesData = data;
          $('#btn-add-passenger-modal').prop('disabled', false);
          $('#btn-submit-modal').prop('disabled', false);
          addPassengerRowModal();
          $('#bookingModal').modal('show');
        },
        error: function() {
          Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kursi.' });
        }
      });
    });

    $('#btn-add-passenger-modal').on('click', addPassengerRowModal);

    $('#passengers-container-modal').on('click', '.btn-remove-passenger', function() {
      $(this).closest('.passenger-row').remove();
      $('#passengers-container-modal').find('.passenger-row').each(function(i, row) {
        $(row).data('index', i + 1);
        $(row).find('.card-header span').text('Penumpang #' + (i + 1));
      });
      toggleRemoveModal();
      updateTotalModal();
    });

    $('#booking-form').on('submit', function(e) {
      e.preventDefault();
      var $btn = $('#btn-submit-modal').prop('disabled', true);
      var originalText = $btn.html();
      $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

      $.ajax({
        url: '{{ route("landing.bookings.store") }}',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.redirect) {
            window.location.href = response.redirect;
          }
        },
        error: function(xhr) {
          $btn.prop('disabled', false).html(originalText);
          var errors = xhr.responseJSON && xhr.responseJSON.errors;
          var msg = '';
          if (errors) {
            for (var key in errors) {
              msg += errors[key].join(', ') + '\n';
            }
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          } else {
            msg = 'Terjadi kesalahan. Silakan coba lagi.';
          }
          Swal.fire({ icon: 'error', title: 'Pemesanan Gagal', text: msg });
        }
      });
    });

    @if(session('success'))
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
    @endif
  });
</script>
@endpush
