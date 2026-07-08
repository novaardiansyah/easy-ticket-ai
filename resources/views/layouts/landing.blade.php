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
    <style>
      body {
        background-color: #f4f5f7;
      }
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
    </style>
    @stack('styles')
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom py-2" style="box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-5" href="{{ route('landing') }}">
          <i class="bi bi-train-front me-1"></i>Easy Ticket AI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-lg-center">
            @auth
              @if (auth()->user()->isAdmin())
              <li class="nav-item">
                <a class="nav-link fw-semibold text-secondary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
              </li>
              @endif
              <li class="nav-item">
                <a class="btn btn-outline-danger btn-sm ms-lg-2 px-3 rounded-pill" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <main>
      @yield('content')
    </main>

    <footer class="custom-footer pt-5 pb-3 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="mb-3">
              <img src="{{ asset('app-logo-16x9.png') }}" alt="Easy Ticket AI" height="90" class="d-inline-block">
            </div>
            <p class="custom-footer-text small">Platform pemesanan tiket kereta api online terpercaya. Pesan tiket dengan mudah, cepat, dan aman.</p>
          </div>
          <div class="col-md-4 mb-4">
            <h6 class="fw-semibold">Informasi</h6>
            <ul class="list-unstyled small">
              <li class="mb-1"><a href="{{ route('privacy') }}" class="custom-footer-link text-decoration-none">Kebijakan Privasi</a></li>
              <li class="mb-1"><a href="{{ route('terms') }}" class="custom-footer-link text-decoration-none">Ketentuan Layanan</a></li>
            </ul>
          </div>
          <div class="col-md-4 mb-4">
            <h6 class="fw-semibold">Kontak</h6>
            <ul class="list-unstyled small custom-footer-text">
              <li class="mb-1"><i class="bi bi-envelope me-1"></i>support@easyticket.ai</li>
              <li class="mb-1"><i class="bi bi-telephone me-1"></i>(021) 1234-5678</li>
              <li class="mb-1"><i class="bi bi-geo-alt me-1"></i>Jakarta, Indonesia</li>
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
    @stack('scripts')
  </body>
</html>
