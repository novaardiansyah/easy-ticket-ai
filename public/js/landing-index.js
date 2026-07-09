window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;
  const configEl = document.getElementById('landing-config');
  if (!configEl) return;

  const routes = {
    getSeats: configEl.dataset.getSeatsUrl,
    bookingsStore: configEl.dataset.bookingsStoreUrl
  };
  const flashSuccess = configEl.dataset.flashSuccess || '';

  let carriagesData = [];
  let passengerIndex = 0;
  let basePrice = 0;



  function populateSeatsDropdown($select) {
    $select.empty().append('<option value="">Pilih Kursi</option>');
    carriagesData.forEach(function (carriage) {
      const $group = $('<optgroup>').attr('label', carriage.name + ' (' + carriage.class + ')');
      carriage.seats.forEach(function (seat) {
        const $option = $('<option>')
          .val(seat.id)
          .text(seat.seat_number + (seat.is_available ? '' : ' (Terpesan)'))
          .prop('disabled', !seat.is_available);
        $group.append($option);
      });
      $select.append($group);
    });
  }

  function addPassengerRowModal() {
    passengerIndex++;
    const num = $('#passengers-container-modal').find('.passenger-row').length + 1;
    const html = $('#passenger-template-modal').html()
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    const $row = $(html);
    $('#passengers-container-modal').append($row);
    populateSeatsDropdown($row.find('.select-seat-modal'));
    updateTotalModal();
    toggleRemoveModal();
  }

  function toggleRemoveModal() {
    const $rows = $('#passengers-container-modal').find('.passenger-row');
    $rows.length <= 1 ? $rows.find('.btn-remove-passenger').hide() : $rows.find('.btn-remove-passenger').show();
  }

  function updateTotalModal() {
    const count = $('#passengers-container-modal').find('.passenger-row').length;
    $('#total-price-modal').text(formatRupiah(count * basePrice));
  }

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

  $(document).on('click', '.btn-book', function () {
    const scheduleId = $(this).data('schedule-id');
    basePrice = $(this).data('base-price');
    $('#modal-schedule-id').val(scheduleId);
    $('#modal-base-price').text(formatRupiah(basePrice));
    $('#passengers-container-modal').empty();
    passengerIndex = 0;
    $('#total-price-modal').text(formatRupiah(0));
    $('#btn-add-passenger-modal').prop('disabled', true);
    $('#btn-submit-modal').prop('disabled', true);

    $.ajax({
      url: routes.getSeats,
      type: 'GET',
      data: { schedule_id: scheduleId },
      success: function (data) {
        carriagesData = data;
        $('#btn-add-passenger-modal').prop('disabled', false);
        $('#btn-submit-modal').prop('disabled', false);
        addPassengerRowModal();
        $('#bookingModal').modal('show');
      },
      error: function () {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kursi.' });
      }
    });
  });

  $('#btn-add-passenger-modal').on('click', addPassengerRowModal);

  $('#passengers-container-modal').on('click', '.btn-remove-passenger', function () {
    $(this).closest('.passenger-row').remove();
    $('#passengers-container-modal').find('.passenger-row').each(function (i, row) {
      $(row).data('index', i + 1);
      $(row).find('.card-header span').text('Penumpang #' + (i + 1));
    });
    toggleRemoveModal();
    updateTotalModal();
  });

  $('#booking-form').on('submit', function (e) {
    e.preventDefault();
    const $btn = $('#btn-submit-modal').prop('disabled', true);
    const originalText = $btn.html();
    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

    $.ajax({
      url: routes.bookingsStore,
      type: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        if (response.redirect) {
          window.location.href = response.redirect;
        }
      },
      error: function (xhr) {
        $btn.prop('disabled', false).html(originalText);
        let msg = '';
        const errors = xhr.responseJSON && xhr.responseJSON.errors;
        if (errors) {
          for (const key in errors) {
            msg += errors[key].join(', ') + '\n';
          }
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          msg = xhr.responseJSON.message;
        } else {
          msg = 'Terjadi kesalahan. Silakan coba lagi.';
        }
        Swal.fire({ icon: 'error', title: 'Pemesanan Gagal', text: msg });
      }
    });
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
