window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;
  const configEl = document.getElementById('booking-config');
  if (!configEl) return;

  const config = {
    getSeatsUrl: configEl.dataset.getSeatsUrl,
    scheduleId: configEl.dataset.scheduleId,
    basePrice: parseInt(configEl.dataset.basePrice, 10) || 0
  };

  let carriagesData = [];
  let passengerIndex = 0;
  let currentStep = 1;
  const totalSteps = 2;

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

  function refreshSeatDropdowns() {
    const $selects = $('#passengers-container .select-seat');
    const taken = {};
    $selects.each(function () {
      const val = $(this).val();
      if (val) taken[val] = true;
    });
    $selects.each(function () {
      const $self = $(this);
      const currentVal = $self.val();
      $self.empty().append('<option value="">Pilih Kursi</option>');
      carriagesData.forEach(function (carriage) {
        const $group = $('<optgroup>').attr('label', carriage.name + ' (' + carriage.class + ')');
        carriage.seats.forEach(function (seat) {
          const isTaken = taken[seat.id] && seat.id !== currentVal;
          const $option = $('<option>')
            .val(seat.id)
            .text(seat.seat_number + (!seat.is_available || isTaken ? ' (Terpesan)' : ''))
            .prop('disabled', !seat.is_available || isTaken);
          $group.append($option);
        });
        $self.append($group);
      });
      $self.val(currentVal);
    });
  }

  function addPassengerRow() {
    passengerIndex++;
    const num = $('#passengers-container').find('.passenger-row').length + 1;
    const html = $('#passenger-template').html()
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    const $row = $(html);
    $('#passengers-container').append($row);
    refreshSeatDropdowns();
    updateTotal();
    toggleRemove();
  }

  function toggleRemove() {
    const $rows = $('#passengers-container').find('.passenger-row');
    $rows.length <= 1 ? $rows.find('.btn-remove-passenger').hide() : $rows.find('.btn-remove-passenger').show();
  }

  function updateTotal() {
    const count = $('#passengers-container').find('.passenger-row').length;
    const total = count * config.basePrice;
    $('#total-price').text(formatRupiah(total));
    $('#summary-passenger-count').text(count);
    $('#summary-total').text(formatRupiah(total));
  }

  function setStep(step) {
    currentStep = step;
    $('.step-pane').removeClass('active');
    $('.step-pane[data-pane="' + step + '"]').addClass('active');
    $('.step').removeClass('active done');
    $('.step').each(function () {
      const s = parseInt($(this).data('step'), 10);
      if (s < step) $(this).addClass('done');
      if (s === step) $(this).addClass('active');
    });
    $('.step-line').removeClass('done');
    for (let i = 1; i < step; i++) {
      $('.step-line[data-line="' + i + '"]').addClass('done');
    }
    $('#btn-prev').prop('disabled', step === 1);
    if (step === totalSteps) {
      $('#btn-next').addClass('d-none');
      $('#btn-submit').removeClass('d-none');
    } else {
      $('#btn-next').removeClass('d-none');
      $('#btn-submit').addClass('d-none');
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function validateStep1() {
    const $form = $('#booking-form');
    const customerName = $('input[name="customer_name"]').val().trim();
    const customerEmail = $('input[name="customer_email"]').val().trim();
    const customerPhone = $('input[name="customer_phone"]').val().trim();
    if (!customerName || !customerEmail || !customerPhone) {
      Swal.fire({ icon: 'warning', title: 'Lengkapi Data', text: 'Nama, email, dan telepon pemesan wajib diisi.' });
      return false;
    }
    let valid = true;
    $('#passengers-container .passenger-row').each(function () {
      const name = $(this).find('input[name*="[passenger_name]"]').val().trim();
      const idNum = $(this).find('input[name*="[passenger_id_number]"]').val().trim();
      const seat = $(this).find('select[name*="[seat_id]"]').val();
      if (!name || !idNum || !seat) valid = false;
    });
    if (!valid) {
      Swal.fire({ icon: 'warning', title: 'Lengkapi Data', text: 'Pastikan semua data penumpang dan kursi terisi.' });
      return false;
    }
    return true;
  }

  $.ajax({
    url: config.getSeatsUrl,
    type: 'GET',
    data: { schedule_id: config.scheduleId },
    success: function (data) {
      carriagesData = data;
      addPassengerRow();
    },
    error: function () {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kursi.' });
    }
  });

  $('#btn-add-passenger').on('click', addPassengerRow);

  $('#passengers-container').on('click', '.btn-remove-passenger', function () {
    $(this).closest('.passenger-row').remove();
    $('#passengers-container').find('.passenger-row').each(function (i, row) {
      $(row).find('.card-header span').text('Penumpang #' + (i + 1));
    });
    refreshSeatDropdowns();
    toggleRemove();
    updateTotal();
  });

  $('#passengers-container').on('change', '.select-seat', function () {
    refreshSeatDropdowns();
  });

  $('#btn-next').on('click', function () {
    if (currentStep === 1 && !validateStep1()) return;
    setStep(currentStep + 1);
  });

  $('#btn-prev').on('click', function () {
    if (currentStep > 1) setStep(currentStep - 1);
  });

  $('#booking-form').on('submit', function (e) {
    e.preventDefault();
    const $btn = $('#btn-submit').prop('disabled', true);
    const originalText = $btn.html();
    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

    $.ajax({
      url: this.action,
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
});
