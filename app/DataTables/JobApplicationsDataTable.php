<?php

namespace App\DataTables;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobApplicationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<JobApplication> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function ($row) {
                return '<div>' .
                    '<div class="fw-medium text-dark">' . e($row->name) . '</div>' .
                    '<small class="text-muted">ID: ' . $row->id . '</small>' .
                    '</div>';
            })
            ->addColumn('contact', function ($row) {
                return '<div class="small">' .
                    '<div class="text-muted"><i class="bx bx-envelope me-1"></i>' . e($row->email) . '</div>' .
                    '<div class="text-muted"><i class="bx bx-phone me-1"></i>' . e($row->phone) . '</div>' .
                    '</div>';
            })
            ->addColumn('job', function ($row) {
                if ($row->job) {
                    $codeHtml = $row->job->job_code ? '<small class="badge bg-label-primary">' . e($row->job->job_code) . '</small>' : '';
                    return '<div>' .
                        '<div class="fw-medium">' . e($row->job->title) . '</div>' .
                        $codeHtml .
                        '</div>';
                }
                return '<span class="badge bg-label-secondary">General Application (Resume Upload)</span>';
            })
            ->addColumn('resume', function ($row) {
                if ($row->resume_url) {
                    return '<a href="' . $row->resume_url . '" target="_blank" class="btn btn-sm btn-outline-primary">' .
                        '<i class="bx bx-download me-1"></i> Download' .
                        '</a>';
                }
                return '<span class="text-muted small">No resume attached</span>';
            })
            ->editColumn('created_at', function ($row) {
                $dateStr = $row->created_at ? $row->created_at->format('M d, Y') : 'N/A';
                $timeStr = $row->created_at ? $row->created_at->format('g:i A') : '';
                return '<small class="text-muted">' . $dateStr . '</small>' .
                    '<div class="small text-muted">' . $timeStr . '</div>';
            })
            ->addColumn('action', function ($row) {
                return view('admin.job-applications.partials.actions', ['row' => $row])->render();
            })
            ->rawColumns(['name', 'contact', 'job', 'resume', 'created_at', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<JobApplication>
     */
    public function query(JobApplication $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['job', 'job.category']);

        if (request()->filled('job_id')) {
            $query->where('job_id', request('job_id'));
        }

        $search = request('search_query');
        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
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
                    ->setTableId('applicationTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', 'function(d) {
                        if ($("#searchForm").length) {
                            $("#searchForm").serializeArray().forEach(function(item) {
                                d[item.name] = item.value;
                            });
                        }
                    }')
                    ->orderBy(4, 'desc') // Sort by created_at (index 4) in descending order by default
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
            Column::make('name')
                  ->title('Applicant')
                  ->addClass('align-middle'),
            Column::computed('contact')
                  ->title('Contact')
                  ->addClass('align-middle'),
            Column::computed('job')
                  ->title('Job Applied For')
                  ->addClass('align-middle'),
            Column::computed('resume')
                  ->title('Resume')
                  ->addClass('align-middle'),
            Column::make('created_at')
                  ->title('Applied At')
                  ->addClass('align-middle'),
            Column::computed('action')
                  ->title('Actions')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center align-middle')
                  ->width(100)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'JobApplications_' . date('YmdHis');
    }
}
