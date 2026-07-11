window.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;

  // Payment option selection
  $('.payment-option').on('click', function () {
    $('.payment-option').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop('checked', true);
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

  // Handle validation errors
  @if($errors->any())
    const $btn = $('#btn-submit');
    const originalText = $('#booking-form').data('original-btn-text') || '<i class="bi bi-check-lg me-1"></i>Pesan Sekarang';
    $btn.prop('disabled', false).html(originalText);
    
    Swal.fire({
      icon: 'error',
      title: 'Pemesanan Gagal',
      text: '{{ $errors->first() }}'
    });
  @endif
});
