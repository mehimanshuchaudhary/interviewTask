<?php

namespace App\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccessDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Role> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query);
        
        if ($this->canShowAction()) {
            $dataTable->addColumn('action', function ($row) {
                return view('utilities.crm-action-buttons', [
                    'edit_url'   => auth()->user()->can('edit_users')
                                    ? route('admin.users.edit', $row->id)
                                    : null,

                    'delete_url' => auth()->user()->can('delete_users')
                                    ? route('admin.users.destroy', $row->id)
                                    : null,
                ]);
            });
        }

        return $dataTable
        ->editColumn('created_at', fn ($row) => optional($row->created_at)->format('d-m-Y'))
        ->editColumn('updated_at', fn ($row) => optional($row->updated_at)->format('d-m-Y'))
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Role>
     */
    public function query(Role $model): QueryBuilder
    {
        $query = $model->newQuery();

        $dateRange = request('date_range');
        // -----------------------------
        // Date Range Filter
        // -----------------------------
        if (!empty($dateRange) && str_contains($dateRange, ' - ')) {
    
            [$start, $end] = explode(' - ', $dateRange);

            try {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
                $endDate   = Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();
        
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // Ignore invalid date formats
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $buttons = [
            Button::make('colvis'),
            Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
        ];

        
        if (1) {
            $buttons[] = Button::raw('add')
                ->text('+ Add User')
                ->attr([
                    'class' => 'btn btn-success',
                ])
                ->action('function (e, dt, node, config) {
                    window.location.href = "' . route('access.create') . '";
                }');
        }

        return $this->builder()
                    ->setTableId('access-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(5, 'desc') // Sort by Created At
                    ->selectStyle('os')
                    ->responsive(true)
                    ->scrollX(true)
                    ->minifiedAjax('', null, [
                        'date_range' => 'function() { return $("#date-range").val(); }',
                        // 'status' => 'function() { return $("#status").val(); }',
                        // 'course_type_id' => 'function() { return $("#course_type_id").val(); }',
                        // 'university_id' => 'function() { return $("#university_id").val(); }',
                        // 'internship_program_id' => 'function() { return $("#internship_program_id").val(); }',
                    ])
                    ->layout([
                        'topStart' => 'buttons',
                        'bottom' => 'pageLength'
                    ])
                    ->buttons($buttons);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Access_' . date('YmdHis');
    }

    protected function canShowAction(): bool
    {
        return auth()->user()->can('edit_users')
            || auth()->user()->can('delete_users');
    }
}
