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
    disableMobile: true,
    onChange: function () { saveSearchToLocalStorage(); }
  });

  $('#destination_station_id').on('change', function () {
    const val = $(this).val();
    if (val && val === $('#origin_station_id').val()) {
      $(this).val('').trigger('change');
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Stasiun tujuan tidak boleh sama dengan stasiun asal.',
        timer: 2000,
        showConfirmButton: false
      });
    }
    saveSearchToLocalStorage();
  });

  $('#origin_station_id').on('change', function () {
    const val = $(this).val();
    if (val && val === $('#destination_station_id').val()) {
      $(this).val('').trigger('change');
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Stasiun asal tidak boleh sama dengan stasiun tujuan.',
        timer: 2000,
        showConfirmButton: false
      });
    }
    saveSearchToLocalStorage();
  });

  $('#swap-stations-btn').on('click', function () {
    const $origin = $('#origin_station_id');
    const $dest = $('#destination_station_id');
    const originVal = $origin.val();
    const destVal = $dest.val();

    $origin.val(destVal);
    $dest.val(originVal);

    $origin.trigger('change');
    $dest.trigger('change');
  });

	function saveSearchToLocalStorage() {
    const data = {
      origin_station_id: $('#origin_station_id').val(),
      destination_station_id: $('#destination_station_id').val(),
      departure_date: $('#departure_date').val()
    };
    localStorage.setItem('easy_ticket_search', JSON.stringify(data));
  }

  function restoreSearchFromLocalStorage() {
    const saved = localStorage.getItem('easy_ticket_search');
    if (!saved) return;
    try {
      const data = JSON.parse(saved);
      if (data.origin_station_id) {
        $('#origin_station_id').val(data.origin_station_id).trigger('change');
      }
      if (data.destination_station_id) {
        $('#destination_station_id').val(data.destination_station_id).trigger('change');
      }
      if (data.departure_date) {
        var fp = document.querySelector('#departure_date');
        if (fp && fp._flatpickr) {
          fp._flatpickr.setDate(data.departure_date, true);
        } else {
          $('#departure_date').val(data.departure_date);
        }
      }
    } catch (e) {
      localStorage.removeItem('easy_ticket_search');
    }
  }

  function doRestore() {
    var restoreSearch = configEl.dataset.restoreSearch || '';
    if (restoreSearch) {
      restoreSearchFromLocalStorage();
    }
  }

  doRestore();
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) doRestore();
  });

  $('#search-form').on('submit', function () {
    saveSearchToLocalStorage();
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