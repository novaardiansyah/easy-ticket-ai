<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Easy Ticket AI | Check Your Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Easy Ticket AI | Check Your Email" />
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
        <div class="card-body login-card-body text-center">
          <div class="my-4">
            <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>
          </div>
          
          <h4 class="mb-3 fw-bold text-dark">Check Your Email</h4>
          
          <p class="text-secondary mb-4">
            We have sent a registration link to your email address. Please check your inbox and click the link to complete your account setup.
          </p>

          <div class="d-grid gap-2">
            <a href="{{ route('login') }}" class="btn btn-primary py-2">Back to Login</a>
          </div>
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
  </body>
</html>
