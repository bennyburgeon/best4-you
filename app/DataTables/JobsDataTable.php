<?php
 
namespace App\DataTables;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Job> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('job_code', function ($row) {
                return '<span class="badge bg-label-primary">' . e($row->job_code ?? 'N/A') . '</span>';
            })
            ->editColumn('title', function ($row) {
                return e($row->title);
            })
            ->editColumn('client', function ($row) {
                $logoHtml = '';
                if ($row->client && $row->client->logo) {
                    $logoHtml = '<img src="' . $row->client->logo . '" alt="Logo" class="rounded me-3" width="30" height="30" style="object-fit: contain;">';
                } else {
                    $logoHtml = '<div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 30px; height: 30px;"><i class="bx bx-building"></i></div>';
                }
                $name = $row->client ? $row->client->title : ($row->company ?? '-');
                return '<div class="d-flex align-items-center">' . $logoHtml . '<span class="fw-medium">' . e($name) . '</span></div>';
            })
            ->editColumn('industry_type', function ($row) {
                return $row->industryType ? e($row->industryType->name) : '-';
            })
            ->editColumn('dates', function ($row) {
                $openStr = $row->opening_date ? $row->opening_date->format('M d, Y') : 'N/A';
                $closeStr = $row->closing_date ? $row->closing_date->format('M d, Y') : 'N/A';
                return '<div class="small">' .
                    '<div class="text-success"><i class="bx bx-calendar-check me-1"></i>' . $openStr . '</div>' .
                    '<div class="text-danger"><i class="bx bx-calendar-x me-1"></i>' . $closeStr . '</div>' .
                    '</div>';
            })
            ->addColumn('action', function ($row) {
                return view('admin.jobs.partials.actions', ['row' => $row])->render();
            })
            ->rawColumns(['job_code', 'client', 'dates', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Job>
     */
    public function query(Job $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['category', 'skills', 'client', 'currency', 'industryType', 'jobType', 'region']);

        // Custom search accordion filters (using request helper to keep Artisan signature)
        if (request()->filled('client_id')) {
            $query->where('client_id', request('client_id'));
        }

        if (request()->filled('industry_type_id')) {
            $query->where('industry_type_id', request('industry_type_id'));
        }

        $customSearch = request('search_query');
        if ($customSearch !== null && $customSearch !== '') {
            $query->where(function ($q) use ($customSearch) {
                $q->where('job_code', 'like', "%{$customSearch}%")
                  ->orWhere('title', 'like', "%{$customSearch}%");
            });
        }

        $dateRange = request('date_range');
        if ($dateRange) {
            $parts = preg_split('/ (to|-) /', $dateRange);
            $isValid = false;
            
            if (count($parts) === 2) {
                $startStr = trim($parts[0]);
                $endStr = trim($parts[1]);
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $startStr) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $endStr)) {
                    $startDate = $startStr . ' 00:00:00';
                    $endDate = $endStr . ' 23:59:59';
                    $isValid = true;
                }
            } else {
                $dateStr = trim($dateRange);
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
                    $startDate = $dateStr . ' 00:00:00';
                    $endDate = $dateStr . ' 23:59:59';
                    $isValid = true;
                }
            }
            
            if ($isValid) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('jobTable')
                    ->columns($this->getColumns())
                    ->ajax([
                        'url' => '',
                        'headers' => ['Accept' => 'application/json'],
                        'data' => 'function(d) {
                            if ($("#searchForm").length) {
                                $("#searchForm").serializeArray().forEach(function(item) {
                                    d[item.name] = item.value;
                                });
                            }
                        }',
                    ])
                    ->orderBy(6, 'desc') // Sort by ID (index 6) in descending order by default
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
            Column::make('job_code')
                  ->title('Code')
                  ->addClass('align-middle'),
            Column::make('title')
                  ->title('Title')
                  ->addClass('fw-medium align-middle'),
            Column::make('client')
                  ->title('Company')
                  ->orderable(false)
                  ->searchable(false)
                  ->addClass('align-middle'),
            Column::make('industry_type')
                  ->title('Industry')
                  ->orderable(false)
                  ->searchable(false)
                  ->addClass('align-middle'),
            Column::make('dates')
                  ->title('Dates')
                  ->orderable(false)
                  ->searchable(false)
                  ->addClass('align-middle'),
            Column::computed('action')
                  ->title('Actions')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center align-middle')
                  ->width(220),
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
        return 'Jobs_' . date('YmdHis');
    }
}
