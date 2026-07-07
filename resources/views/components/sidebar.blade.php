<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('home') }}" class="brand-link">
      <img
        src="{{ url('app-logo-1x1.png') }}"
        alt="Easy Ticket AI Logo"
        class="brand-image opacity-100 shadow"
      />
      <span class="brand-text fw-light">Easy Ticket AI</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="navigation"
        aria-label="Main navigation"
        data-accordion="false"
        id="navigation"
      >
        <li class="nav-header">Main Menu</li>

        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}">
            <i class="nav-icon bi bi-palette"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">Master Data</li>

        <li class="nav-item">
          <a href="{{ route('admin.stations.index') }}" class="nav-link{{ request()->routeIs('admin.stations.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-geo-alt-fill"></i>
            <p>Stations</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.trains.index') }}" class="nav-link{{ request()->routeIs('admin.trains.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-train-front"></i>
            <p>Trains</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.carriages.index') }}" class="nav-link{{ request()->routeIs('admin.carriages.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-layers-fill"></i>
            <p>Carriages</p>
          </a>
        </li>

        <li class="nav-header">Routes &amp; Schedules</li>

        <li class="nav-item">
          <a href="{{ route('admin.routes.index') }}" class="nav-link{{ request()->routeIs('admin.routes.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-signpost-2-fill"></i>
            <p>Routes</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.schedules.index') }}" class="nav-link{{ request()->routeIs('admin.schedules.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-calendar-event-fill"></i>
            <p>Schedules</p>
          </a>
        </li>

        <li class="nav-header">Transactions</li>

        <li class="nav-item">
          <a href="{{ route('admin.bookings.index') }}" class="nav-link{{ request()->routeIs('admin.bookings.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-receipt"></i>
            <p>Bookings</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.payments.index') }}" class="nav-link{{ request()->routeIs('admin.payments.*') ? ' active' : '' }}">
            <i class="nav-icon bi bi-credit-card-2-front-fill"></i>
            <p>Payments</p>
          </a>
        </li>

        <li class="nav-header">Account</li>

        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start rounded-0 text-body-secondary">
              <i class="nav-icon bi bi-box-arrow-left"></i>
              <p>Logout</p>
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</aside>
