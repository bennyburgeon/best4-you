/* Users Module - Admin Logic */
$(document).ready(function() {
    $('.select2-multiple').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#userModal')
    });
});

window.openDialog = function(id = null, name = '', email = '', rolesList = []) {
    var myModal = new bootstrap.Modal(document.getElementById('userModal'));
    var form = document.getElementById('userForm');
    var baseUrl = form.getAttribute('data-url');
    
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = '';
    
    $('#roles').val(rolesList).trigger('change');
    
    if (id) {
        document.getElementById('modalTitle').innerText = 'Edit User';
        document.getElementById('formMethod').value = 'PUT';
        form.action = baseUrl + '/' + id;
        document.getElementById('password').required = false;
        document.getElementById('passwordLabel').innerText = 'Password (Optional)';
        document.getElementById('passwordHelp').classList.remove('d-none');
    } else {
        document.getElementById('modalTitle').innerText = 'New User';
        document.getElementById('formMethod').value = 'POST';
        form.action = baseUrl;
        document.getElementById('password').required = true;
        document.getElementById('passwordLabel').innerText = 'Password *';
        document.getElementById('passwordHelp').classList.add('d-none');
    }
    
    myModal.show();
};
