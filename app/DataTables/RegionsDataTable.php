<?php

namespace App\DataTables;

use App\Models\Region;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RegionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Region> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function ($row) {
                return '<span class="fw-medium">#' . $row->id . '</span>';
            })
            ->editColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge bg-label-success bg-success text-white text-center">Active</span>';
                } else {
                    return '<span class="badge bg-label-danger bg-danger text-white text-center">Inactive</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return view('admin.regions.partials.actions', ['row' => $row])->render();
            })
            ->rawColumns(['id', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Region $model): QueryBuilder
    {
        $query = $model->newQuery();

        $search = request('search_query');
        if ($search !== null && $search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('regionTable')
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
                    ->orderBy(0, 'desc') // Sort by ID (index 0) in descending order by default
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
            Column::make('id')
                  ->title('ID')
                  ->addClass('align-middle'),
            Column::make('name')
                  ->title('Name')
                  ->addClass('align-middle'),
            Column::make('slug')
                  ->title('Slug')
                  ->addClass('align-middle'),
            Column::make('status')
                  ->title('Status')
                  ->addClass('text-center align-middle'),
            Column::computed('action')
                  ->title('Actions')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center align-middle')
                  ->width(150)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Regions_' . date('YmdHis');
    }
}
