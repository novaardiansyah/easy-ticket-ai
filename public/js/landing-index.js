window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;
  const configEl = document.getElementById('landing-config');
  if (!configEl) return;

  const flashSuccess = configEl.dataset.flashSuccess || '';

  $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

  flatpickr('#departure_date', {
    locale: 'id',
    minDate: 'today',
    altInput: true,
    altFormat: 'l, d F Y',
    dateFormat: 'Y-m-d',
    disableMobile: true
  });

  $('#destination_station_id').on('change', function () {
    const val = $(this).val();
    if (val && val === $('#origin_station_id').val()) {
      $('#destination_station_id').val('').trigger('change');
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Stasiun tujuan tidak boleh sama dengan stasiun asal.',
        timer: 2000,
        showConfirmButton: false
      });
    }
  });

  $('#origin_station_id').on('change', function () {
    const val = $(this).val();
    if (val && val === $('#destination_station_id').val()) {
      $('#origin_station_id').val('').trigger('change');
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Stasiun asal tidak boleh sama dengan stasiun tujuan.',
        timer: 2000,
        showConfirmButton: false
      });
    }
  });

  if (flashSuccess) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: flashSuccess,
      timer: 3000,
      showConfirmButton: false
    });
  }
});