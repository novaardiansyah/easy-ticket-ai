@extends('layouts.auth')

@section('title', 'Login')

@section('content')
					<img src="{{ url('app-logo-16x9.png') }}" alt="Easy Ticket AI" class="w-100" style="max-height: 100px; object-fit: contain;" />

          <p class="login-box-msg">Sign in to start your session</p>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus />
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
              <button class="input-group-text" type="button" id="togglePassword" style="cursor: pointer; background: transparent;">
                <span class="bi bi-eye-slash" id="toggleIcon"></span>
              </button>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                  <label class="form-check-label" for="remember"> Remember Me </label>
                </div>
              </div>
              <div class="col-4 mt-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
            </div>
          </form>

          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1" style="color: #dee2e6; opacity: 1; margin: 0;" />
            <span class="mx-3 text-muted small">or</span>
            <hr class="flex-grow-1" style="color: #dee2e6; opacity: 1; margin: 0;" />
          </div>

          <div class="d-grid gap-2">
            <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2 py-2" style="border-color: #dee2e6; color: #495057; background-color: #fff; transition: all 0.2s ease;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.5 24c0-1.61-.15-3.16-.42-4.69H24v8.89h12.62c-.54 2.85-2.15 5.27-4.57 6.89l7.1 5.5C43.34 36.63 46.5 30.82 46.5 24z"/>
                <path fill="#FBBC05" d="M10.54 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.98-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.1-5.5c-1.97 1.32-4.49 2.11-8.79 2.11-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
              </svg>
              Sign in with Google
            </a>
          </div>

          <div class="d-flex justify-content-between mt-3">
            <a href="#" class="small text-decoration-none">Forgot password?</a>
            <a href="{{ route('register') }}" class="small text-decoration-none">Register</a>
          </div>
@endsection

@push('scripts')
    <script>
      document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          toggleIcon.classList.remove('bi-eye-slash');
          toggleIcon.classList.add('bi-eye');
        } else {
          passwordInput.type = 'password';
          toggleIcon.classList.remove('bi-eye');
          toggleIcon.classList.add('bi-eye-slash');
        }
      });
    </script>
@endpush
