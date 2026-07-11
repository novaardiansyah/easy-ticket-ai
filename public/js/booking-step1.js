window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;
  const configEl = document.getElementById('booking-config');
  if (!configEl) return;

  const config = {
    getSeatsUrl: configEl.dataset.getSeatsUrl,
    scheduleId: configEl.dataset.scheduleId,
    basePrice: parseInt(configEl.dataset.basePrice, 10) || 0
  };

  // Get old passengers data and validation errors from server
  const oldPassengers = JSON.parse(configEl.dataset.oldPassengers || '[]');
  const errors = JSON.parse(configEl.dataset.errors || '{}');

  // Get fake data for local environment auto-fill
  const fakeData = JSON.parse(configEl.dataset.fakeData || '{}');
  const appEnv = configEl.dataset.appEnv;

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

  function addPassengerRow(passengerData = null) {
    passengerIndex++;
    const num = $('#passengers-container').find('.passenger-card').length + 1;
    const html = $('#passenger-template').html()
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    const $row = $(html);

    // If passenger data provided (from old input), populate the fields
    if (passengerData) {
      $row.find('input[name*="[passenger_name]"]').val(passengerData.passenger_name || '');
      $row.find('select[name*="[passenger_id_type]"]').val(passengerData.passenger_id_type || 'ktp');
      $row.find('input[name*="[passenger_id_number]"]').val(passengerData.passenger_id_number || '');
      // Seat will be populated after seats are loaded
      if (passengerData.seat_id) {
        $row.data('seat-id', passengerData.seat_id);
      }
    }

    $('#passengers-container').append($row);
    refreshAllSeatDropdowns();

    // Apply saved seat selection if exists
    if (passengerData && passengerData.seat_id) {
      $row.find('select[name*="[seat_id]"]').val(passengerData.seat_id);
    }

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

  function applyServerErrors() {
    // Apply customer errors
    if (errors.customer_name) {
      $('input[name="customer_name"]').addClass('is-invalid');
    }
    if (errors.customer_email) {
      $('input[name="customer_email"]').addClass('is-invalid');
    }
    if (errors.customer_phone) {
      $('input[name="customer_phone"]').addClass('is-invalid');
    }

    // Apply passenger errors
    if (errors.passengers) {
      Object.keys(errors.passengers).forEach(function (key) {
        // key format: "0.passenger_name", "1.seat_id", etc.
        const match = key.match(/^(\d+)\.(.+)$/);
        if (match) {
          const index = parseInt(match[1], 10);
          const field = match[2];
          const $card = $('#passengers-container .passenger-card').eq(index);
          if ($card.length) {
            const $input = $card.find('[name*="[' + field + ']"]');
            if ($input.length) {
              $input.addClass('is-invalid');
            }
          }
        }
      });
    }
  }

  function applyFakeData() {
    // Only apply fake data in local environment and when no old passengers exist
    if (appEnv !== 'local' || oldPassengers.length > 0 || !fakeData.passengers || fakeData.passengers.length === 0) {
      return false;
    }

    // Auto-fill customer fields
    if (fakeData.customer_name) {
      $('input[name="customer_name"]').val(fakeData.customer_name);
    }
    if (fakeData.customer_email) {
      $('input[name="customer_email"]').val(fakeData.customer_email);
    }
    if (fakeData.customer_phone) {
      $('input[name="customer_phone"]').val(fakeData.customer_phone);
    }

    // Auto-fill passenger fields (only 1 passenger)
    const passenger = fakeData.passengers[0];
    if (passenger) {
      // Update the first (and only) passenger row
      const $firstCard = $('#passengers-container .passenger-card').first();
      if ($firstCard.length) {
        $firstCard.find('input[name*="[passenger_name]"]').val(passenger.passenger_name || '');
        $firstCard.find('select[name*="[passenger_id_type]"]').val(passenger.passenger_id_type || 'ktp');
        $firstCard.find('input[name*="[passenger_id_number]"]').val(passenger.passenger_id_number || '');
        if (passenger.seat_id) {
          $firstCard.data('seat-id', passenger.seat_id);
          $firstCard.find('select[name*="[seat_id]"]').val(passenger.seat_id);
        }
      }
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

      // If there are old passengers from server validation, restore them
      if (oldPassengers.length > 0) {
        oldPassengers.forEach(function (passenger, index) {
          addPassengerRow(passenger);
        });
      } else {
        // Add first passenger row
        addPassengerRow();
        
        // Apply fake data for local environment
        applyFakeData();
      }

      // Apply server-side validation errors
      applyServerErrors();
    },
    error: function () {
      alert('Gagal memuat data kursi.');
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
});