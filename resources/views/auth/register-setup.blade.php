<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Easy Ticket AI | Setup Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Easy Ticket AI | Setup Account" />
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ template('css/adminlte.css') }}" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ template('css/adminlte.css') }}" />
  </head>
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="card pb-3">
        <div class="card-body login-card-body">
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
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="{{ template('js/adminlte.js') }}"></script>
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
  </body>
</html>
