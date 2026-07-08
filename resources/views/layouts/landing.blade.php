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
    <style>
      .custom-footer {
        background-color: #ffffff;
        color: #475569;
        border-top: 1px solid #e2e8f0;
      }
      .custom-footer h5, .custom-footer h6 {
        color: #0f172a;
      }
      .custom-footer-link {
        color: #64748b;
        transition: color 0.2s ease-in-out;
      }
      .custom-footer-link:hover {
        color: #1a73e8;
        text-decoration: none;
      }
      .custom-footer-text {
        color: #64748b;
      }
      .custom-footer-divider {
        border-color: #e2e8f0 !important;
        opacity: 1;
      }
      .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
      }
    </style>
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
            <a href="{{ route('home') }}" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-grid-1x2-fill me-1.5"></i>Dashboard</a>
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
              <li class="mb-1"><i class="bi bi-envelope me-1"></i>admin@novaardiansyah.id</li>
              <li class="mb-1"><i class="bi bi-telephone me-1"></i>0822 6111 1084</li>
              <li class="mb-1"><i class="bi bi-geo-alt me-1"></i>Tangerang Selatan, Banten, Indonesia</li>
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
