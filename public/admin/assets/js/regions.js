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
    // Live search: trigger redraw on every change or keyup in searchForm
    $('#searchForm input, #searchForm select').on('keyup change input', function () {
        if (window.LaravelDataTables && window.LaravelDataTables["regionTable"]) {
            window.LaravelDataTables["regionTable"].draw();
        }
    });
});
