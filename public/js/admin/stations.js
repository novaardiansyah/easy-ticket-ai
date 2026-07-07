$(document).ready(function() {
  const $table = $('#stations-table');
  if ($table.length === 0) {
    return;
  }
  const ajaxUrl           = $table.data('ajax-url');
  const csrfToken         = $table.data('csrf-token');
  const showUrlTemplate   = $table.data('show-url-template');
  const editUrlTemplate   = $table.data('edit-url-template');
  const deleteUrlTemplate = $table.data('delete-url-template');
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
        data: 'code',
        render: function(data) {
          return `<span class="badge bg-secondary">${data}</span>`;
        }
      },
      { data: 'name' },
      { data: 'city' },
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
                  <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Delete this station?')">
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
