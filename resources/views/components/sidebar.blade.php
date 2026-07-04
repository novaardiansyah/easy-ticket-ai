<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand d-block p-0" style="height: auto;">
    <a href="{{ route('home') }}" class="brand-link">
      <img
        src="{{ url('app-logo-16x9.png') }}"
        alt="Easy Ticket AI"
        class="brand-image opacity-100 w-100 shadow"
				style="max-height: 120px; object-fit: cover;"
      />
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
        {{-- <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              Dashboard
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link active">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
          </ul>
        </li> --}}

				<li class="nav-header">Main Menu</li>

				<li class="nav-item">
					<a href="{{ route('home') }}" class="nav-link">
						<i class="nav-icon bi bi-palette"></i>
						<p>Dashboard</p>
					</a>
				</li>

        <li class="nav-header">Authentication</li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-box-arrow-in-right"></i>
            <p>
              Auth
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">
                <i class="nav-icon bi bi-arrow-right-short"></i>
                <p>Login</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-arrow-right-short"></i>
                <p>Register</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>
