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
  const totalSteps = 3;

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
  
  function refreshAllSeatDropdowns() {
    const $selects = $('#passengers-container .seat-select');
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
    const num = $('#passengers-container').find('.passenger-card').length + 1;
    const html = $('#passenger-template').html()
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    const $row = $(html);
    $('#passengers-container').append($row);
    refreshAllSeatDropdowns();
    updateTotal();
    toggleRemoveButtons();
  }

  function toggleRemoveButtons() {
    const $rows = $('#passengers-container').find('.passenger-card');
    $rows.length <= 1
      ? $rows.find('.btn-remove-passenger').prop('disabled', true)
      : $rows.find('.btn-remove-passenger').prop('disabled', false);
  }

  function updateTotal() {
    const count = $('#passengers-container').find('.passenger-card').length;
    const total = count * config.basePrice;
    $('#total-price').text(formatRupiah(total));
    $('#summary-passenger-count').text(count);
    $('#summary-total').text(formatRupiah(total));
  }

  function setStep(step) {
    currentStep = step;
    $('.step-pane').removeClass('active');
    $('.step-pane[data-pane="' + step + '"]').addClass('active');

    $('.step').removeClass('active completed');
    $('.step').each(function () {
      const s = parseInt($(this).data('step'), 10);
      if (s < step) $(this).addClass('completed');
      if (s === step) $(this).addClass('active');
    });

    const progressPercent = ((step - 1) / (totalSteps - 1)) * 100;
    $('#step-line').css('width', progressPercent + '%');

    $('#btn-prev').prop('disabled', step === 1);
    if (step === totalSteps) {
      $('#btn-next').addClass('d-none');
      $('#btn-submit').addClass('d-none');
    } else if (step === totalSteps - 1) {
      $('#btn-next').addClass('d-none');
      $('#btn-submit').removeClass('d-none');
    } else {
      $('#btn-next').removeClass('d-none');
      $('#btn-submit').addClass('d-none');
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function validateStep1() {
    const customerName = $('input[name="customer_name"]').val().trim();
    const customerEmail = $('input[name="customer_email"]').val().trim();
    const customerPhone = $('input[name="customer_phone"]').val().trim();
    if (!customerName || !customerEmail || !customerPhone) {
      Swal.fire({ icon: 'warning', title: 'Lengkapi Data', text: 'Nama, email, dan telepon pemesan wajib diisi.' });
      return false;
    }
    let valid = true;
    $('#passengers-container .passenger-card').each(function () {
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

  function showConfirmation(bookingData) {
    $('#confirm-booking-code').text(bookingData.booking_code);
    $('#confirm-customer-name').text(bookingData.customer_name);
    $('#confirm-customer-email').text(bookingData.customer_email);
    $('#confirm-customer-phone').text(bookingData.customer_phone);
    $('#confirm-train').text(bookingData.train_name + ' (' + bookingData.train_code + ')');
    $('#confirm-route').text(bookingData.origin_code + ' \u2192 ' + bookingData.destination_code);
    $('#confirm-departure').text(bookingData.departure_time);
    $('#confirm-arrival').text(bookingData.arrival_time);
    $('#confirm-payment-method').text(bookingData.payment_method);
    $('#confirm-total').text(formatRupiah(bookingData.total_price));

    const $tbody = $('#confirm-passengers-table tbody');
    $tbody.empty();
    bookingData.passengers.forEach(function (p) {
      $tbody.append('<tr><td>' + p.passenger_name + '</td><td>' + p.seat_number + '</td><td><span class="badge bg-dark">' + p.ticket_number + '</span></td></tr>');
    });

    if (bookingData.payment_status === 'pending') {
      $('#confirm-pending').removeClass('d-none');
      $('#confirm-paid').addClass('d-none');
      $('#confirm-bank-info').removeClass('d-none');
    } else {
      $('#confirm-pending').addClass('d-none');
      $('#confirm-paid').removeClass('d-none');
      $('#confirm-bank-info').addClass('d-none');
    }
  }

  setStep(1);

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
    if ($(this).prop('disabled')) return;
    $(this).closest('.passenger-card').remove();
    $('#passengers-container').find('.passenger-card').each(function (i, row) {
      $(row).find('.card-header h6').text('Penumpang #' + (i + 1));
    });
    refreshAllSeatDropdowns();
    toggleRemoveButtons();
    updateTotal();
  });

  $('#passengers-container').on('change', '.seat-select', function () {
    refreshAllSeatDropdowns();
  });

  $('.payment-option').on('click', function () {
    $('.payment-option').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop('checked', true);
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
          // Extract booking code from redirect URL and show confirmation on step 3
          const bookingCode = response.redirect.split('/').pop();
          $.ajax({
            url: '/bookings/success/' + bookingCode,
            type: 'GET',
            success: function (html) {
              const $doc = $(html);
              const bookingCodeText = $doc.find('.booking-code').text().trim();
              const status = $doc.find('.alert').hasClass('alert-warning') ? 'pending' : 'paid';
              const customerName = $doc.find('table tr:eq(0) td:eq(1)').text().trim();
              const customerEmail = $doc.find('table tr:eq(1) td:eq(1)').text().trim();
              const customerPhone = $doc.find('table tr:eq(2) td:eq(1)').text().trim();
              const train = $doc.find('table:eq(1) tr:eq(0) td:eq(1)').text().trim();
              const route = $doc.find('table:eq(1) tr:eq(1) td:eq(1)').text().trim();
              const departure = $doc.find('table:eq(1) tr:eq(2) td:eq(1)').text().trim();
              const arrival = $doc.find('table:eq(1) tr:eq(3) td:eq(1)').text().trim();
              const paymentMethod = $doc.find('table:eq(2) tr:eq(0) td:eq(1)').text().trim();
              const totalPrice = $doc.find('table:eq(2) tr:eq(1) td:eq(1)').text().trim();
              const passengers = [];
              $doc.find('.table tbody tr').each(function () {
                const tds = $(this).find('td');
                passengers.push({
                  passenger_name: tds.eq(0).text().trim(),
                  seat_number: tds.eq(1).text().trim(),
                  ticket_number: tds.eq(2).text().trim()
                });
              });

              showConfirmation({
                booking_code: bookingCodeText,
                payment_status: status,
                customer_name: customerName,
                customer_email: customerEmail,
                customer_phone: customerPhone,
                train_name: train.split(' (')[0],
                train_code: train.split(' (')[1]?.replace(')', '') || '',
                origin_code: route.split(' \u2192 ')[0],
                destination_code: route.split(' \u2192 ')[1],
                departure_time: departure,
                arrival_time: arrival,
                payment_method: paymentMethod.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()),
                total_price: parseInt(totalPrice.replace(/\D/g, ''), 10) || 0,
                passengers: passengers
              });
              setStep(3);
            },
            error: function () {
              window.location.href = response.redirect;
            }
          });
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
