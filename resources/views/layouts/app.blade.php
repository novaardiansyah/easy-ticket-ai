<!doctype html>
<html lang="en">
  <head>
    @include('components.head')
  </head>
  <body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
      @include('components.navbar')
      @include('components.sidebar')
      <main class="app-main">
        @yield('content-header')
        <div class="app-content pb-4">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </main>
      @include('components.footer')
    </div>
    @include('components.scripts')
  </body>
</html>
