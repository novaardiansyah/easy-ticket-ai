@extends('layouts.auth')

@section('title', 'Setup Account')

@section('content')
          <img src="{{ url('app-logo-16x9.png') }}" alt="Easy Ticket AI" class="w-100" style="max-height: 100px; object-fit: contain;" />

          <p class="login-box-msg">Complete your registration</p>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('register.setup.submit') }}" method="post">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}" />
            
            <div class="mb-3">
              <label class="form-label small text-muted">Full Name</label>
              <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name', $name) }}" required autofocus />
                <div class="input-group-text">
                  <span class="bi bi-person"></span>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small text-muted">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                <button class="input-group-text" type="button" id="togglePassword" style="cursor: pointer; background: transparent;">
                  <span class="bi bi-eye-slash" id="toggleIcon"></span>
                </button>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small text-muted">Confirm Password</label>
              <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required />
                <button class="input-group-text" type="button" id="togglePasswordConfirm" style="cursor: pointer; background: transparent;">
                  <span class="bi bi-eye-slash" id="toggleIconConfirm"></span>
                </button>
              </div>
            </div>

            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary py-2">Complete Registration</button>
            </div>
          </form>
@endsection

@push('scripts')
    <script>
      function setupToggle(buttonId, inputId, iconId) {
        document.getElementById(buttonId).addEventListener('click', function () {
          const input = document.getElementById(inputId);
          const icon = document.getElementById(iconId);
          if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
          } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
          }
        });
      }
      setupToggle('togglePassword', 'password', 'toggleIcon');
      setupToggle('togglePasswordConfirm', 'password_confirmation', 'toggleIconConfirm');
    </script>
@endpush
