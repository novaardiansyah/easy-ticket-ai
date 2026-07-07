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
