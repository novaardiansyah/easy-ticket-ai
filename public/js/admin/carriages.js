$(document).ready(function() {
  const $table = $('#carriages-table');
  if ($table.length === 0) {
    return;
  }
  const ajaxUrl           = $table.data('ajax-url');
  const csrfToken         = $table.data('csrf-token');
  const editUrlTemplate   = $table.data('edit-url-template');
  const deleteUrlTemplate = $table.data('delete-url-template');
  const table = $table.DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    ajax: {
      url: ajaxUrl,
      type: 'GET',
      data: function(d) {
        d.train_id = $('select[name="train_id"]').val();
      }
    },
    columns: [
      {
        data: 'train',
        render: function(data) {
          return data ? `${data.name} <span class="badge bg-secondary">${data.code}</span>` : '-';
        }
      },
      { data: 'name' },
      {
        data: 'class',
        render: function(data) {
          return `<span class="badge bg-info">${data}</span>`;
        }
      },
      { data: 'capacity' },
      {
        data: 'id',
        searchable: false,
        className: 'text-center',
        render: function(data) {
          const editUrl   = editUrlTemplate.replace(':id', data);
          const deleteUrl = deleteUrlTemplate.replace(':id', data);
          return `
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="${editUrl}"><i class="bi bi-pencil me-2 text-secondary"></i> Edit</a></li>
                <li>
                  <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Delete this carriage?')">
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
  $('select[name="train_id"]').on('change', function() {
    table.ajax.reload();
  });
});
