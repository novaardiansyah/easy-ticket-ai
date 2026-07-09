/**
 * Format rupiah currency.
 *
 * @param {number|string} value
 * @param {number} decimals
 * @returns {string}
 */
function formatRupiah(value, decimals = 0) {
  return 'Rp' + Number(value).toLocaleString('id-ID', {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals,
  });
}
