@extends('layouts.landing')

@section('title', 'Hasil Pencarian Tiket')

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
        @include('landing.partials._search-form')
      </div>
    </div>
  </div>
</div>

<div class="container pt-md-4" id="search-results">

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
              <h4 class="text-primary fw-bold mb-0">{{ formatRupiah($schedule->base_price) }}</h4>
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
            <a href="{{ route('landing.bookings.create', ['data' => Crypt::encryptString(json_encode(['schedule_id' => $schedule->id]))]) }}" class="btn btn-primary w-100 mt-3">
              <i class="bi bi-ticket-perforated me-1"></i>Pesan Tiket
            </a>
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
@endsection

@push('scripts')
<div id="landing-config" data-flash-success="{{ session('success') }}"></div>
<script src="{{ asset('js/landing-index.js?v1.1') }}"></script>
<script>
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }
  window.addEventListener('load', function () {
    var el = document.querySelector('.search-card-wrapper');
    if (el) {
      var header = document.querySelector('.sticky-header');
      var offset = header ? header.offsetHeight : 0;
      var top = el.getBoundingClientRect().top + window.pageYOffset - offset - 20;
      window.scrollTo({ top: top, behavior: 'smooth' });
    }
  });
</script>
@endpush