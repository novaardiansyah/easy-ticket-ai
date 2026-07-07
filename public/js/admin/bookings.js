$(document).ready(function() {
  const $table = $('#bookings-table');
  if ($table.length === 0) {
    return;
  }
  const ajaxUrl           = $table.data('ajax-url');
  const showUrlTemplate   = $table.data('show-url-template');
  function formatDateTime(val) {
    if (!val) {
      return '-';
    }
    const d      = new Date(val);
    const day    = String(d.getDate()).padStart(2, '0');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const month  = months[d.getMonth()];
    const hours  = String(d.getHours()).padStart(2, '0');
    const mins   = String(d.getMinutes()).padStart(2, '0');
    return `${day} ${month} ${hours}:${mins}`;
  }
  function formatRupiah(val) {
    if (val === null || val === undefined) {
      return '-';
    }
    return 'Rp ' + Number(val).toLocaleString('id-ID');
  }
  $table.DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    ajax: {
      url: ajaxUrl,
      type: 'GET'
    },
    columns: [
      {
        data: 'booking_code',
        render: function(data) {
          return `<span class="badge bg-dark">${data}</span>`;
        }
      },
      {
        data: 'customer_name',
        render: function(data, type, row) {
          return data || (row.user ? row.user.name : '-');
        }
      },
      {
        data: 'schedule',
        render: function(data) {
          if (data && data.train) {
            return `${data.train.code} &middot; ${formatDateTime(data.departure_time)}`;
          }
          return '-';
        }
      },
      {
        data: 'total_price',
        render: function(data) {
          return formatRupiah(data);
        }
      },
      {
        data: 'status',
        render: function(data) {
          const map = { paid: 'success', pending: 'warning', cancelled: 'danger', expired: 'secondary' };
          const cls = map[data] || 'secondary';
          return `<span class="badge bg-${cls}">${data}</span>`;
        }
      },
      {
        data: 'created_at',
        render: function(data) {
          return formatDateTime(data);
        }
      },
      {
        data: 'id',
        searchable: false,
        className: 'text-center',
        render: function(data) {
          const showUrl = showUrlTemplate.replace(':id', data);
          return `
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="${showUrl}"><i class="bi bi-eye me-2 text-secondary"></i> Show</a></li>
              </ul>
            </div>
          `;
        }
      }
    ]
  });
});
