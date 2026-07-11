<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@yield('title', 'Dashboard')</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
<meta name="color-scheme" content="light dark" />
<meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
<meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />

<meta name="title" content="AdminLTE v4 | Dashboard" />
<meta name="author" content="ColorlibHQ" />
<meta
  name="description"
  content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
/>
<meta
  name="keywords"
  content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
/>

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
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2-bootstrap-5-theme.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/datepicker/flatpickr.min.css') }}" />
<style>
  div.dataTables_wrapper div.dataTables_processing {
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
  }
  table.dataTable {
    margin-top: 15px !important;
    margin-bottom: 15px !important;
  }

  [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection {
    background-color: var(--bs-body-bg);
    border-color: var(--bs-border-color);
  }
  [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    color: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .select2-dropdown {
    background-color: var(--bs-body-bg);
    border-color: var(--bs-border-color);
  }
  [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option {
    color: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: var(--bs-primary);
    color: #fff;
  }
  [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-search__field {
    color: var(--bs-body-color);
  }

  [data-bs-theme="dark"] .flatpickr-calendar {
    background: var(--bs-body-bg);
    border-color: var(--bs-border-color);
    box-shadow: none;
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-months .flatpickr-month,
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months,
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-weekdays,
  [data-bs-theme="dark"] .flatpickr-calendar span.flatpickr-weekday {
    color: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-prev-month svg,
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-next-month svg {
    fill: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day {
    color: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day.today {
    border-color: var(--bs-primary);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day.selected {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
    color: #fff;
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day:hover {
    background: var(--bs-tertiary-bg);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day.inRange {
    background: var(--bs-tertiary-bg);
    border-color: var(--bs-tertiary-bg);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day.flatpickr-disabled {
    color: var(--bs-secondary-color);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-day.flatpickr-disabled:hover {
    background: none;
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-time input {
    color: var(--bs-body-color);
    background: var(--bs-body-bg);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-time .flatpickr-time-separator,
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-time .flatpickr-am-pm {
    color: var(--bs-body-color);
  }
  [data-bs-theme="dark"] .flatpickr-calendar .flatpickr-time .flatpickr-am-pm:hover {
    background: var(--bs-tertiary-bg);
  }
</style>
@stack('styles')
