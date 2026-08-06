/* Regions Module - Admin Logic */
window.openDialog = function(id = null, name = '', status = true) {
    var myModal = new bootstrap.Modal(document.getElementById('regionModal'));
    var form = document.getElementById('regionForm');
    var baseUrl = form.getAttribute('data-url');
    
    document.getElementById('name').value = name;
    document.getElementById('status').checked = status;
    
    if (id) {
        document.getElementById('modalTitle').innerText = 'Edit Region';
        document.getElementById('formMethod').value = 'PUT';
        form.action = baseUrl + '/' + id;
    } else {
        document.getElementById('modalTitle').innerText = 'New Region';
        document.getElementById('formMethod').value = 'POST';
        form.action = baseUrl;
    }
    
    myModal.show();
};

$(function() {
    var tableEl = $('#regionTable');
    if (!tableEl.length) return;
    
    var ajaxUrl = tableEl.data('ajax-url');
    var destroyUrlTemplate = tableEl.data('destroy-url');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    var columnsConfig = [
        { 
            data: 'id', 
            name: 'id',
            render: function(data, type, row) {
                return '<span class="fw-medium">#' + data + '</span>';
            }
        },
        { 
            data: 'name', 
            name: 'name' 
        },
        { 
            data: 'slug', 
            name: 'slug' 
        },
        { 
            data: 'status', 
            name: 'status',
            className: 'text-center',
            render: function(data, type, row) {
                if (data) {
                    return '<span class="badge bg-label-success bg-success text-white">Active</span>';
                } else {
                    return '<span class="badge bg-label-danger bg-danger text-white">Inactive</span>';
                }
            }
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            render: function(data, type, row) {
                var escapedName = escapeHtml(row.name).replace(/'/g, "\\'");
                var isChecked = row.status ? 'true' : 'false';
                
                var editBtn = '<button type="button" class="btn btn-sm btn-info text-white" onclick="openDialog(' + row.id + ', \'' + escapedName + '\', ' + isChecked + ')">' +
                    '<i class="bx bx-edit-alt me-1"></i> Edit' +
                    '</button>';
                    
                var deleteUrl = destroyUrlTemplate.replace(':id', row.id);
                
                var deleteBtn = '<form action="' + deleteUrl + '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this region?\');">' +
                    '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                    '<input type="hidden" name="_method" value="DELETE">' +
                    '<button type="submit" class="btn btn-sm btn-danger">' +
                    '<i class="bx bx-trash me-1"></i> Delete' +
                    '</button>' +
                    '</form>';
                    
                return '<div class="d-flex justify-content-center gap-2">' + editBtn + deleteBtn + '</div>';
            }
        }
    ];

    if (window.initializeAdminDataTable) {
        initializeAdminDataTable('#regionTable', ajaxUrl, columnsConfig, '#searchForm', [[0, 'desc']]);
    }
});
