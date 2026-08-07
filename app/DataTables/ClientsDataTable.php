<?php

namespace App\DataTables;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Client> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('title', function ($row) {
                $logoHtml = '';
                if ($row->logo) {
                    $logoHtml = '<img src="' . $row->logo . '" alt="Logo" class="rounded me-3" width="30" height="30" style="object-fit: contain;">';
                } else {
                    $logoHtml = '<div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 30px; height: 30px;"><i class="bx bx-building"></i></div>';
                }
                return '<div class="d-flex align-items-center">' . $logoHtml . '<span class="fw-medium">' . e($row->title) . '</span></div>';
            })
            ->addColumn('contact', function ($row) {
                $contactHtml = '<div class="small">';
                if ($row->contact_email) {
                    $contactHtml .= '<div class="text-muted"><i class="bx bx-envelope me-1"></i>' . e($row->contact_email) . '</div>';
                }
                if ($row->contact_number) {
                    $contactHtml .= '<div class="text-muted"><i class="bx bx-phone me-1"></i>' . e($row->contact_number) . '</div>';
                }
                $contactHtml .= '</div>';
                return $contactHtml;
            })
            ->addColumn('hr_contact', function ($row) {
                $hrHtml = '<div class="small">';
                if ($row->hr_name) {
                    $hrHtml .= '<div class="fw-medium">' . e($row->hr_name) . '</div>';
                }
                if ($row->hr_email) {
                    $hrHtml .= '<div class="text-muted"><i class="bx bx-envelope me-1"></i>' . e($row->hr_email) . '</div>';
                }
                $hrHtml .= '</div>';
                return $hrHtml;
            })
            ->editColumn('verified', function ($row) {
                if ($row->verified == 1 || $row->verified == true) {
                    return '<span class="badge bg-label-success"><i class="bx bx-check-circle"></i> Verified</span>';
                }
                return '<span class="badge bg-label-secondary">Unverified</span>';
            })
            ->addColumn('action', function ($row) {
                return view('admin.clients.partials.actions', ['row' => $row])->render();
            })
            ->rawColumns(['title', 'contact', 'hr_contact', 'verified', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Client>
     */
    public function query(Client $model): QueryBuilder
    {
        $query = $model->newQuery();

        if (request()->filled('verified')) {
            $query->where('verified', filter_var(request('verified'), FILTER_VALIDATE_BOOLEAN));
        }

        $search = request('search_query');
        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('clientTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', 'function(d) {
                        if ($("#searchForm").length) {
                            $("#searchForm").serializeArray().forEach(function(item) {
                                d[item.name] = item.value;
                            });
                        }
                    }')
                    ->orderBy(5, 'desc') // Sort by ID (index 5) in descending order by default
                    ->selectStyleSingle()
                    ->parameters([
                        'processing' => true,
                        'serverSide' => true,
                        'pageLength' => 20,
                        'lengthMenu' => [10, 20, 50, 100],
                        'responsive' => true,
                        'language' => [
                            'search' => "",
                            'searchPlaceholder' => "Search...",
                            'processing' => '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                        ],
                        'dom' => '<"d-flex justify-content-between align-items-center header-actions mx-3 my-2"l>t<"d-flex justify-content-between mx-3 my-2"ip>',
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('title')
                  ->title('Company Name')
                  ->addClass('align-middle'),
            Column::computed('contact')
                  ->title('Contact')
                  ->addClass('align-middle'),
            Column::computed('hr_contact')
                  ->title('HR Contact')
                  ->addClass('align-middle'),
            Column::make('verified')
                  ->title('Verified')
                  ->addClass('text-center align-middle'),
            Column::computed('action')
                  ->title('Actions')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center align-middle')
                  ->width(150),
            Column::make('id')
                  ->visible(false)
                  ->searchable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Clients_' . date('YmdHis');
    }
}
