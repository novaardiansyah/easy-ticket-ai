$(document).ready(function() {
  const $table = $('#schedules-table');
  if ($table.length === 0) {
    return;
  }
  const ajaxUrl           = $table.data('ajax-url');
  const csrfToken         = $table.data('csrf-token');
  const showUrlTemplate   = $table.data('show-url-template');
  const editUrlTemplate   = $table.data('edit-url-template');
  const deleteUrlTemplate = $table.data('delete-url-template');
  function formatDateTime(val) {
    if (!val) {
      return '-';
    }
    const d      = new Date(val);
    const day    = String(d.getDate()).padStart(2, '0');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const month  = months[d.getMonth()];
    const year   = d.getFullYear();
    const hours  = String(d.getHours()).padStart(2, '0');
    const mins   = String(d.getMinutes()).padStart(2, '0');
    return `${day} ${month} ${year} ${hours}:${mins}`;
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
        data: 'train',
        render: function(data) {
          return data ? `${data.name} <span class="badge bg-secondary">${data.code}</span>` : '-';
        }
      },
      {
        data: 'route',
        render: function(data) {
          if (data && data.origin_station && data.destination_station) {
            return `${data.origin_station.code} &rarr; ${data.destination_station.code}`;
          }
          return '?';
        }
      },
      {
        data: 'departure_time',
        render: function(data) {
          return formatDateTime(data);
        }
      },
      {
        data: 'arrival_time',
        render: function(data) {
          return formatDateTime(data);
        }
      },
      {
        data: 'base_price',
        render: function(data) {
          return formatRupiah(data);
        }
      },
      {
        data: 'id',
        searchable: false,
        className: 'text-center',
        render: function(data) {
          const showUrl   = showUrlTemplate.replace(':id', data);
          const editUrl   = editUrlTemplate.replace(':id', data);
          const deleteUrl = deleteUrlTemplate.replace(':id', data);
          return `
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="${showUrl}"><i class="bi bi-eye me-2 text-info"></i> Show</a></li>
                <li><a class="dropdown-item" href="${editUrl}"><i class="bi bi-pencil me-2 text-warning"></i> Edit</a></li>
                <li>
                  <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                  </form>
                </li>
              </ul>
            </div>
          `;
        }
      }
    ]
  });
});
