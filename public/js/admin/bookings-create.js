$(document).ready(function() {
  let carriagesData  = [];
  let passengerIndex = 0;
  let basePrice      = 0;
  const $scheduleSelect      = $('#schedule_id');
  const $btnAddPassenger     = $('#btn-add-passenger');
  const $btnSubmit           = $('#btn-submit');
  const $passengersContainer = $('#passengers-container');
  const $totalPriceDisplay   = $('#total-price-display');
  const $rowTemplate         = $('#passenger-row-template').html();
  function formatRupiah(val) {
    return 'Rp ' + Number(val).toLocaleString('id-ID');
  }
  function updateTotalPrice() {
    const passengerCount = $passengersContainer.find('.passenger-row').length;
    const total          = passengerCount * basePrice;
    $totalPriceDisplay.text(formatRupiah(total));
  }
  function populateSeatsDropdown($select) {
    $select.empty().append('<option value="">Select Seat</option>');
    carriagesData.forEach(function(carriage) {
      const $group = $('<optgroup>').attr('label', `${carriage.name} (${carriage.class})`);
      carriage.seats.forEach(function(seat) {
        const $option = $('<option>')
          .val(seat.id)
          .text(seat.seat_number + (seat.is_available ? '' : ' (Booked)'))
          .prop('disabled', !seat.is_available);
        $group.append($option);
      });
      $select.append($group);
    });
  }
  function addPassengerRow() {
    passengerIndex++;
    const num = $passengersContainer.find('.passenger-row').length + 1;
    let html  = $rowTemplate
      .replace(/{index}/g, passengerIndex)
      .replace(/{number}/g, num);
    const $row = $(html);
    $passengersContainer.append($row);
    const $seatSelect = $row.find('.select-seat');
    populateSeatsDropdown($seatSelect);
    updateTotalPrice();
    toggleRemoveButtons();
  }
  function toggleRemoveButtons() {
    const $rows = $passengersContainer.find('.passenger-row');
    if ($rows.length <= 1) {
      $rows.find('.btn-remove-passenger').hide();
    } else {
      $rows.find('.btn-remove-passenger').show();
    }
  }
  $scheduleSelect.on('change', function() {
    const scheduleId = $(this).val();
    if (!scheduleId) {
      $btnAddPassenger.prop('disabled', true);
      $btnSubmit.prop('disabled', true);
      $passengersContainer.empty();
      basePrice = 0;
      updateTotalPrice();
      return;
    }
    basePrice = Number($(this).find('option:selected').data('price') || 0);
    $btnAddPassenger.prop('disabled', false);
    $btnSubmit.prop('disabled', false);
    $.ajax({
      url: getSeatsUrl,
      type: 'GET',
      data: { schedule_id: scheduleId },
      success: function(data) {
        carriagesData = data;
        $passengersContainer.empty();
        addPassengerRow();
      },
      error: function() {
        alert('Failed to retrieve seats data. Please try again.');
      }
    });
  });
  $btnAddPassenger.on('click', function() {
    addPassengerRow();
  });
  $passengersContainer.on('click', '.btn-remove-passenger', function() {
    $(this).closest('.passenger-row').remove();
    $passengersContainer.find('.passenger-row').each(function(i, row) {
      $(row).find('.card-title').text('Passenger #' + (i + 1));
    });
    toggleRemoveButtons();
    updateTotalPrice();
  });
});
