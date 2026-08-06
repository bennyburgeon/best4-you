/**
 * Initializes a standardized DataTable for the admin dashboard.
 *
 * @param {string} tableSelector jQuery selector for the target table
 * @param {string} ajaxUrl URL for the server-side request
 * @param {array} columnsConfig Column configuration definitions for DataTables
 * @param {string} customFiltersFormSelector Selector for the search accordion form
 * @param {array} orderConfig Default sorting config (e.g. [[0, 'desc']])
 */
window.initializeAdminDataTable = function(tableSelector, ajaxUrl, columnsConfig, customFiltersFormSelector = '#searchForm', orderConfig = [[0, 'desc']]) {
    const table = $(tableSelector).DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        lengthMenu: [10, 20, 50, 100],
        responsive: true,
        order: orderConfig,
        ajax: {
            url: ajaxUrl,
            type: 'GET',
            data: function (d) {
                if (customFiltersFormSelector) {
                    // Serialize form values and append to dataTables request parameters
                    $(customFiltersFormSelector).serializeArray().forEach(function (item) {
                        d[item.name] = item.value;
                    });
                }
            }
        },
        columns: columnsConfig,
        language: {
            search: "",
            searchPlaceholder: "Search...",
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        }
    });

    // Live search: trigger redraw on every keyup, input, or change inside the search accordion form
    if (customFiltersFormSelector) {
        $(customFiltersFormSelector + ' input, ' + customFiltersFormSelector + ' select').on('keyup change input', function () {
            table.draw();
        });
        
        // Prevent form submission on enter key
        $(customFiltersFormSelector).on('submit', function(e) {
            e.preventDefault();
        });
        // Initialize flatpickr range pickers if present
        if (typeof flatpickr !== 'undefined') {
            $('.flatpickr-range').flatpickr({
                mode: 'range',
                dateFormat: 'Y-m-d',
                allowInput: true,
                onClose: function(selectedDates, dateStr, instance) {
                    table.draw();
                }
            });
        }
    }

    return table;
};
