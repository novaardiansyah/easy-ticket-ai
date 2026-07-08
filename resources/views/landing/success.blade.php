@extends('layouts.landing')

@section('title', 'Pemesanan Berhasil')

@push('styles')
<style>
  .invoice-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
  }
  .invoice-header {
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
  }
  .booking-code {
    font-size: 1.8rem;
    letter-spacing: 3px;
    font-weight: 800;
  }
  .countdown-box {
    background: #fff3cd;
    border: 1px solid #ffe69c;
    border-radius: 12px;
    padding: 16px;
  }
  .bank-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 12px 16px;
  }
</style>
@endpush

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="text-center mb-4">
        <div class="fs-1 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h3 class="fw-bold">Pemesanan Berhasil!</h3>
        <p class="text-secondary">Tiket kereta api Anda sedang diproses.</p>
      </div>

      <div class="card invoice-card shadow-sm">
        <div class="card-body p-0">
          <div class="invoice-header text-white p-4 text-center">
            <p class="mb-1 opacity-75 small">KODE BOOKING</p>
            <h2 class="booking-code mb-0">{{ $booking->booking_code }}</h2>
          </div>

          <div class="p-4">
            @if ($booking->status === 'pending')
            <div class="countdown-box text-center mb-4">
              <p class="mb-1 fw-semibold"><i class="bi bi-clock me-1"></i>Selesaikan Pembayaran dalam</p>
              <h4 class="fw-bold text-warning mb-0">2 Jam</h4>
              <p class="small text-secondary mt-1 mb-0">Pemesanan akan otomatis dibatalkan jika melewati batas waktu.</p>
            </div>

            <div class="alert alert-warning small d-flex align-items-center">
              <i class="bi bi-exclamation-triangle me-2 fs-5"></i>
              <span>Status pembayaran: <strong>PENDING</strong>. Silakan transfer sesuai total tagihan.</span>
            </div>
            @else
            <div class="alert alert-success d-flex align-items-center">
              <i class="bi bi-check-circle me-2 fs-5"></i>
              <span>Status pembayaran: <strong>LUNAS</strong>. Terima kasih!</span>
            </div>
            @endif

            <h6 class="fw-semibold border-bottom pb-2 mt-4"><i class="bi bi-info-circle me-1"></i>Detail Pemesanan</h6>
            <table class="table table-borderless small">
              <tr><td class="text-secondary ps-0">Nama Pemesan</td><td class="fw-semibold">{{ $booking->customer_name }}</td></tr>
              <tr><td class="text-secondary ps-0">Email</td><td>{{ $booking->customer_email }}</td></tr>
              <tr><td class="text-secondary ps-0">Telepon</td><td>{{ $booking->customer_phone }}</td></tr>
            </table>

            <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-train-front me-1"></i>Jadwal Perjalanan</h6>
            <table class="table table-borderless small">
              <tr><td class="text-secondary ps-0">Kereta</td><td class="fw-semibold">{{ $booking->schedule->train->name }} ({{ $booking->schedule->train->code }})</td></tr>
              <tr><td class="text-secondary ps-0">Rute</td><td>{{ $booking->schedule->route->originStation->city }} ({{ $booking->schedule->route->originStation->code }}) &rarr; {{ $booking->schedule->route->destinationStation->city }} ({{ $booking->schedule->route->destinationStation->code }})</td></tr>
              <tr><td class="text-secondary ps-0">Keberangkatan</td><td>{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M Y H:i') }}</td></tr>
              <tr><td class="text-secondary ps-0">Kedatangan</td><td>{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('d M Y H:i') }}</td></tr>
            </table>

            @if ($booking->passengers->count())
            <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-people me-1"></i>Penumpang ({{ $booking->passengers->count() }})</h6>
            <table class="table table-sm table-bordered small">
              <thead class="table-light">
                <tr><th>Nama</th><th>Kursi</th><th>No. Tiket</th></tr>
              </thead>
              <tbody>
                @foreach ($booking->passengers as $p)
                <tr>
                  <td>{{ $p->passenger_name }}</td>
                  <td>{{ $p->seat->seat_number ?? '-' }}</td>
                  <td><span class="badge bg-dark">{{ $p->ticket_number }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif

            <h6 class="fw-semibold border-bottom pb-2"><i class="bi bi-credit-card me-1"></i>Pembayaran</h6>
            <table class="table table-borderless small">
              <tr><td class="text-secondary ps-0">Metode</td><td class="fw-semibold">{{ str_replace('_', ' ', ucfirst($booking->payment->payment_method)) }}</td></tr>
              <tr><td class="text-secondary ps-0">Total Bayar</td><td class="fw-bold fs-5 text-primary ps-0">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td></tr>
            </table>

            @if ($booking->payment->payment_method === 'bank_transfer' && $booking->status === 'pending')
            <h6 class="fw-semibold border-bottom pb-2 mt-4"><i class="bi bi-bank me-1"></i>Instruksi Bank Transfer</h6>
            <div class="bank-item mb-2 d-flex justify-content-between align-items-center">
              <div><small class="text-secondary d-block">Bank BCA</small><span class="fw-bold">123-456-7890</span></div>
              <small class="text-secondary">a.n. PT Easy Ticket AI</small>
            </div>
            <div class="bank-item mb-2 d-flex justify-content-between align-items-center">
              <div><small class="text-secondary d-block">Bank Mandiri</small><span class="fw-bold">123-456-7890</span></div>
              <small class="text-secondary">a.n. PT Easy Ticket AI</small>
            </div>
            <div class="bank-item d-flex justify-content-between align-items-center">
              <div><small class="text-secondary d-block">Bank BRI</small><span class="fw-bold">123-456-7890</span></div>
              <small class="text-secondary">a.n. PT Easy Ticket AI</small>
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="text-center mt-4">
        <a href="{{ route('landing') }}" class="btn btn-primary"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</div>
@endpush
