@once
    @push('styles')
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
        <style>
            /* Hide the default search box since we are using our custom search accordion */
            .dataTables_filter {
                display: none !important;
            }
            /* Style and align the page length selection dropdown (Show entries) */
            .dataTables_length label {
                display: inline-flex !important;
                align-items: center !important;
                gap: 0.35rem !important;
                color: #697a8d;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }
            .dataTables_length select {
                padding: 0.25rem 1.75rem 0.25rem 0.5rem !important;
                margin: 0 0.15rem !important;
                border: 1px solid #d9dee3 !important;
                border-radius: 0.375rem !important;
                color: #697a8d !important;
                font-weight: 600 !important;
                background-color: #f5f5f9 !important;
                cursor: pointer;
                outline: none;
            }
            /* Styling to match the admin dashboard (Sneat) */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0;
                margin-left: 0;
            }
            .dataTables_wrapper .dataTables_info {
                padding-top: 0.85em;
                font-size: 0.85rem;
                color: #a1b0cb;
            }
            div.dataTables_wrapper div.dataTables_paginate ul.pagination {
                margin: 10px 0;
                justify-content: flex-end;
            }
            .table-responsive {
                padding: 0.5rem;
                overflow-x: auto;
            }
            /* Custom Search Accordion Styles */
            .accordion-button:not(.collapsed) {
                background-color: rgba(105, 108, 255, 0.08);
                color: #696cff;
                box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
            }
            .accordion-button:focus {
                border-color: rgba(105, 108, 255, 0.5);
                box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.15);
            }
            .accordion-item {
                border: 1px solid #d9dee3 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <script>
            /**
             * Initializes a standardized DataTable for the admin dashboard.
             *
             * @param {string} tableSelector jQuery selector for the target table
             * @param {string} ajaxUrl URL for the server-side request
             * @param {array} columnsConfig Column configuration definitions for DataTables
             * @param {string} customFiltersFormSelector Selector for the search accordion form
             * @param {array} orderConfig Default sorting config (e.g. [[0, 'desc']])
             */
            function initializeAdminDataTable(tableSelector, ajaxUrl, columnsConfig, customFiltersFormSelector = '#searchForm', orderConfig = [[0, 'desc']]) {
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
            }
        </script>
    @endpush
@endonce
