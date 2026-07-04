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

<script
  src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
  crossorigin="anonymous"
></script>

<script>
  new Sortable(document.querySelector('.connectedSortable'), {
    group: 'shared',
    handle: '.card-header',
  });
  const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
  cardHeaders.forEach((cardHeader) => {
    cardHeader.style.cursor = 'move';
  });
</script>

<script
  src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
  integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
  crossorigin="anonymous"
></script>

<script
  src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
  integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
  crossorigin="anonymous"
></script>

<script
  src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
  integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
  crossorigin="anonymous"
></script>

@stack('scripts')
