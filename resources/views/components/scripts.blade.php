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
  const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
  const Default = {
    scrollbarTheme: 'os-theme-light',
    scrollbarAutoHide: 'leave',
    scrollbarClickScroll: true,
  };
  document.addEventListener('DOMContentLoaded', function () {
    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
    const isMobile = window.innerWidth <= 992;
    if (
      sidebarWrapper &&
      OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
      !isMobile
    ) {
      OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
        scrollbars: {
          theme: Default.scrollbarTheme,
          autoHide: Default.scrollbarAutoHide,
          clickScroll: Default.scrollbarClickScroll,
        },
      });
    }
  });
</script>

<script>
  (() => {
    'use strict';
    const STORAGE_KEY = 'lte-theme';
    const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
    const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
    const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
    const getPreferredTheme = () => {
      const stored = getStoredTheme();
      if (stored) return stored;
      return prefersDark() ? 'dark' : 'light';
    };
    const setTheme = (theme) => {
      const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
      document.documentElement.setAttribute('data-bs-theme', resolved);
    };
    setTheme(getPreferredTheme());
    const showActiveTheme = (theme) => {
      document.querySelectorAll('[data-bs-theme-value]').forEach((el) => {
        el.classList.remove('active');
        el.setAttribute('aria-pressed', 'false');
        const check = el.querySelector('.bi-check-lg');
        if (check) check.classList.add('d-none');
      });
      const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
      if (active) {
        active.classList.add('active');
        active.setAttribute('aria-pressed', 'true');
        const check = active.querySelector('.bi-check-lg');
        if (check) check.classList.remove('d-none');
      }
      document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
        icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme);
      });
    };
    globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
      const stored = getStoredTheme();
      if (!stored || stored === 'auto') setTheme(getPreferredTheme());
    });
    document.addEventListener('DOMContentLoaded', () => {
      showActiveTheme(getPreferredTheme());
      document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value');
          setStoredTheme(theme);
          setTheme(theme);
          showActiveTheme(theme);
        });
      });
    });
  })();
</script>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>

@stack('scripts')
