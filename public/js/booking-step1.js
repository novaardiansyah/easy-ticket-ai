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

  function populateSeatsDropdown($select) {
    $select.empty().append('<option value="">Pilih Kursi</option>');
    carriagesData.forEach(function (carriage) {
      const $group = $('<optgroup>').attr('label', carriage.name + ' (' + carriage.class + ')');
      carriage.seats.forEach(function (seat) {
        const $option = $('<option>')
          .val(seat.id)
          .text(seat.seat_number + (seat.is_available ? '' : ' (Terpesan)'))
          .prop('disabled', !seat.is_available)
          .attr('data-seat-number', seat.seat_number);
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
            .prop('disabled', !seat.is_available || isTaken)
            .attr('data-seat-number', seat.seat_number);
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
  }

  function validateForm() {
    const customerName = $('input[name="customer_name"]').val().trim();
    const customerEmail = $('input[name="customer_email"]').val().trim();
    const customerPhone = $('input[name="customer_phone"]').val().trim();
    
    if (!customerName || !customerEmail || !customerPhone) {
      Swal.fire({ 
        icon: 'warning', 
        title: 'Lengkapi Data', 
        text: 'Nama, email, dan telepon pemesan wajib diisi.' 
      });
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
      Swal.fire({ 
        icon: 'warning', 
        title: 'Lengkapi Data', 
        text: 'Pastikan semua data penumpang dan kursi terisi.' 
      });
      return false;
    }

    return true;
  }

  // Initialize: Load seats
  $.ajax({
    url: config.getSeatsUrl,
    type: 'GET',
    data: { schedule_id: config.scheduleId },
    success: function (data) {
      carriagesData = data;
      addPassengerRow();
    },
    error: function () {
      Swal.fire({ 
        icon: 'error', 
        title: 'Error', 
        text: 'Gagal memuat data kursi.' 
      });
    }
  });

  // Add passenger button
  $('#btn-add-passenger').on('click', addPassengerRow);

  // Remove passenger button
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

  // Seat change handler
  $('#passengers-container').on('change', '.seat-select', function () {
    refreshAllSeatDropdowns();
  });

  // Form submission
  $('#booking-form').on('submit', function (e) {
    if (!validateForm()) {
      e.preventDefault();
      return false;
    }
  });
});
