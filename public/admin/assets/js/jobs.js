/* Jobs Module - Admin Logic */
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
    $('.select2-tags').select2({
        theme: 'bootstrap-5',
        tags: true,
        tokenSeparators: [',']
    });

    // Quill Rich Text Editor integration
    const textarea = $('#roles_and_responsibility');
    if (textarea.length) {
        // Hide the original textarea
        textarea.hide();

        // Create editor container
        const editorContainer = $('<div id="quill-editor" style="height: 250px;"></div>');
        textarea.after(editorContainer);

        // Initialize Quill
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'clean']
                ]
            }
        });

        // Load initial content (if any, e.g. from old input / model value)
        quill.root.innerHTML = textarea.val();

        // Synchronize editor content to textarea on changes
        quill.on('text-change', function() {
            let html = quill.root.innerHTML;
            if (quill.getText().trim().length === 0) {
                html = '';
            }
            textarea.val(html);
        });

        // Ensure content is synced before form submission
        textarea.closest('form').on('submit', function() {
            let html = quill.root.innerHTML;
            if (quill.getText().trim().length === 0) {
                html = '';
            }
            textarea.val(html);
        });
    }
});
