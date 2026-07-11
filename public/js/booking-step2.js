window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;

  // Payment option selection - use change event on radio for reliable detection
  $('input[name="payment_method"]').on('change', function () {
    $('.payment-option').removeClass('selected');
    $(this).closest('.payment-option').addClass('selected');
  });

  // Also handle direct clicks on payment option divs (for padding areas)
  $('.payment-option').on('click', function (e) {
    // Only handle clicks directly on the div, not on label/radio
    if (e.target === this) {
      $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    }
  });

  // Form submission with loading state
  $('#booking-form').on('submit', function (e) {
    const $btn = $('#btn-submit');
    const originalText = $btn.html();
    
    $btn.prop('disabled', true);
    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

    // Store original text in case of error
    $(this).data('original-btn-text', originalText);
  });
});