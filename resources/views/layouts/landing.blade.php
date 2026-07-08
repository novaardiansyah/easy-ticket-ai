<!doctype html>
<html lang="id" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Easy Ticket AI | @yield('title', 'Pesan Tiket Kereta Api Online')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
    @stack('styles')
  </head>
  <body>

    <header class="sticky-header py-3">
      <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('landing') }}" class="text-decoration-none d-flex align-items-center">
          <span class="fs-5 fw-bold text-primary"><i class="bi bi-ticket-perforated-fill me-2"></i>Easy Ticket AI</span>
        </a>
        <div>
          @auth
            <div class="dropdown">
              <button class="btn btn-light btn-sm rounded-pill px-2 d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d6efd&color=fff&size=64" alt="{{ auth()->user()->name }}" width="28" height="28" class="rounded-circle">
                <span class="fw-semibold small">{{ auth()->user()->name }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="min-width: 200px;">
                <li><h6 class="dropdown-header small text-secondary">Halo, {{ auth()->user()->name }}</h6></li>
                <li><a class="dropdown-item small" href="{{ url('/profile') }}"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                <li><a class="dropdown-item small" href="{{ url('/bookings/history') }}"><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item small text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Daftar</a>
          @endauth
        </div>
      </div>
    </header>

    <main>
      @yield('content')
    </main>

    <footer class="custom-footer pt-5 pb-3 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="mb-3" style="margin-top: -8px;">
              <img src="{{ asset('app-logo-16x9.png') }}" alt="Easy Ticket AI" height="110" class="d-inline-block">
            </div>
            <p class="custom-footer-text small">Platform pemesanan tiket kereta api online terpercaya.<br>Pesan tiket dengan mudah, cepat, dan aman.</p>
          </div>
          <div class="col-md-3 mb-4">
            <h6 class="fw-semibold">Informasi</h6>
            <ul class="list-unstyled small">
              <li class="mb-1"><a href="{{ route('privacy') }}" class="custom-footer-link text-decoration-none">Kebijakan Privasi</a></li>
              <li class="mb-1"><a href="{{ route('terms') }}" class="custom-footer-link text-decoration-none">Ketentuan Layanan</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-4">
            <h6 class="fw-semibold">Kontak</h6>
            <ul class="list-unstyled small custom-footer-text">
              <li class="mb-1"><i class="bi bi-envelope me-2"></i><a href="mailto:admin@novaardiansyah.id" class="custom-footer-link text-decoration-none">admin@novaardiansyah.id</a></li>
              <li class="mb-1"><i class="bi bi-whatsapp me-2"></i><a href="https://wa.me/6282261111084" target="_blank" rel="noopener" class="custom-footer-link text-decoration-none">0822 6111 1084</a></li>
              <li class="mb-1"><i class="bi bi-geo-alt me-2"></i><a href="https://maps.app.goo.gl/6P11mtGWLbq5TC5C7" target="_blank" rel="noopener" class="custom-footer-link text-decoration-none">Tangerang Selatan, Banten, Indonesia</a></li>
            </ul>
          </div>
        </div>
        <hr class="custom-footer-divider">
        <p class="text-center custom-footer-text small mb-0">&copy; {{ date('Y') }} Easy Ticket AI. All rights reserved.</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    @stack('scripts')
  </body>
</html>
