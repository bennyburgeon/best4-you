/* Roles Module - Admin Logic */
$(document).ready(function() {
    $('.select2-multiple').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#roleModal')
    });
});

window.openDialog = function(id = null, name = '', perms = []) {
    var myModal = new bootstrap.Modal(document.getElementById('roleModal'));
    var form = document.getElementById('roleForm');
    var baseUrl = form.getAttribute('data-url');
    
    document.getElementById('name').value = name;
    
    $('#permissions').val(perms).trigger('change');
    
    if (id) {
        document.getElementById('modalTitle').innerText = 'Edit Role';
        document.getElementById('formMethod').value = 'PUT';
        form.action = baseUrl + '/' + id;
    } else {
        document.getElementById('modalTitle').innerText = 'New Role';
        document.getElementById('formMethod').value = 'POST';
        form.action = baseUrl;
    }
    
    myModal.show();
};
