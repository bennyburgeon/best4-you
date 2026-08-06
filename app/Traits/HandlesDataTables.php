<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesDataTables
{
    /**
     * Paginate, search, and sort query for jQuery DataTables.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @param array $searchColumns Columns to search globally or individually
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginateDataTable($query, Request $request, array $searchColumns = [])
    {
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 20);
        $order = $request->input('order');
        $columns = $request->input('columns');

        $tableName = $query->getModel()->getTable();

        // Get total count of original records (before filter)
        $totalRecords = $query->count();

        // 1. Custom individual filters from request parameters (e.g., dropdowns)
        foreach ($request->all() as $key => $value) {
            // Exclude DataTables specific parameters and search box fields
            if (in_array($key, ['draw', 'columns', 'order', 'start', 'length', 'search', 'search_query', 'date_range', 'date_column', '_'])) {
                continue;
            }

            if ($value !== null && $value !== '') {
                // If filtering by verification status for clients
                if ($key === 'verified') {
                    $query->where($tableName . '.verified', filter_var($value, FILTER_VALIDATE_BOOLEAN));
                }
                // Handle foreign keys and exact matches directly
                elseif (str_ends_with($key, '_id') || in_array($key, ['id', 'status'])) {
                    $query->where($tableName . '.' . $key, $value);
                }
            }
        }

        // 2. Custom multi-column search box (e.g., search_query = 'Finance' or search_query = 'J01')
        $customSearch = $request->input('search_query');
        if ($customSearch !== null && $customSearch !== '') {
            $query->where(function ($q) use ($customSearch, $searchColumns, $tableName) {
                foreach ($searchColumns as $index => $column) {
                    // Check if it's a relationship search (e.g., 'client.title')
                    if (str_contains($column, '.')) {
                        list($relation, $relColumn) = explode('.', $column);
                        if ($index === 0) {
                            $q->whereHas($relation, function ($rq) use ($relColumn, $customSearch) {
                                $rq->where($relColumn, 'like', "%{$customSearch}%");
                            });
                        } else {
                            $q->orWhereHas($relation, function ($rq) use ($relColumn, $customSearch) {
                                $rq->where($relColumn, 'like', "%{$customSearch}%");
                            });
                        }
                    } else {
                        // Qualify standard search columns
                        $qualifiedColumn = str_contains($column, '.') ? $column : ($tableName . '.' . $column);
                        if ($index === 0) {
                            $q->where($qualifiedColumn, 'like', "%{$customSearch}%");
                        } else {
                            $q->orWhere($qualifiedColumn, 'like', "%{$customSearch}%");
                        }
                    }
                }
            });
        }

        // 3. Global search parameter from DataTables native search box
        $globalSearch = $request->input('search.value');
        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch, $searchColumns, $tableName) {
                foreach ($searchColumns as $index => $column) {
                    if (str_contains($column, '.')) {
                        list($relation, $relColumn) = explode('.', $column);
                        if ($index === 0) {
                            $q->whereHas($relation, function ($rq) use ($relColumn, $globalSearch) {
                                $rq->where($relColumn, 'like', "%{$globalSearch}%");
                            });
                        } else {
                            $q->orWhereHas($relation, function ($rq) use ($relColumn, $globalSearch) {
                                $rq->where($relColumn, 'like', "%{$globalSearch}%");
                            });
                        }
                    } else {
                        $qualifiedColumn = str_contains($column, '.') ? $column : ($tableName . '.' . $column);
                        if ($index === 0) {
                            $q->where($qualifiedColumn, 'like', "%{$globalSearch}%");
                        } else {
                            $q->orWhere($qualifiedColumn, 'like', "%{$globalSearch}%");
                        }
                    }
                }
            });
        }

        // 4. Date Range filter (using flatpickr range e.g. "2026-08-01 to 2026-08-06" or single day "2026-08-01")
        $dateRange = $request->input('date_range');
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
                $dateColumn = $request->input('date_column', 'created_at');
                
                // Qualify column name
                if (!str_contains($dateColumn, '.')) {
                    $dateColumn = $tableName . '.' . $dateColumn;
                }
                
                $query->whereBetween($dateColumn, [$startDate, $endDate]);
            }
        }

        // Get total count after filtering
        $filteredRecords = $query->count();

        // Apply sorting
        if ($order && isset($order[0])) {
            $orderColumnIndex = $order[0]['column'];
            $orderDir = $order[0]['dir'];
            if (isset($columns[$orderColumnIndex]['data'])) {
                $orderColumn = $columns[$orderColumnIndex]['data'];
                
                // Allow order columns that are in search columns or standard tracking columns
                if (!str_contains($orderColumn, '.')) {
                    $query->orderBy($tableName . '.' . $orderColumn, $orderDir);
                }
            }
        } else {
            $query->orderBy($tableName . '.id', 'desc');
        }

        // Apply pagination
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
