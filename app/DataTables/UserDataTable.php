<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query);
        
        if ($this->canShowAction()) {
            $dataTable->addColumn('action', function ($row) {
                return view('utilities.crm-action-buttons', [
                    'edit_url'   => auth()->user()->can('edit_users')
                                    ? route('users.edit', $row->id)
                                    : null,

                    'delete_url' => auth()->user()->can('delete_users')
                                    ? route('users.destroy', $row->id)
                                    : null,
                ]);
            });
        }

        return $dataTable
        ->editColumn('created_at', fn ($row) => optional($row->created_at)->format('d-m-Y'))
        ->editColumn('updated_at', fn ($row) => optional($row->updated_at)->format('d-m-Y'))
        ->addColumn('roles', function ($user) {
            return $user->roles->map(function($role) {
                return '<span class="badge bg-primary">' . $role->name . '</span>';
            })->implode(' ');
        })
        ->rawColumns(['roles', 'action'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery()->with('roles');

        $dateRange = request('date_range');
        if (!empty($dateRange) && str_contains($dateRange, ' - ')) {
            [$start, $end] = explode(' - ', $dateRange);
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
                $endDate   = Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {}
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

        if (auth()->user()->can('create_users')) {
            $buttons[] = Button::raw('add')
                ->text('+ Add User')
                ->attr(['class' => 'btn btn-success'])
                ->action('function (e, dt, node, config) {
                    window.location.href = "' . route('users.create') . '";
                }');
        }

        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(4, 'desc') // Sort by Created At
                    ->selectStyle('os')
                    ->responsive(true)
                    ->scrollX(true)
                    ->minifiedAjax('', null, [
                        'date_range' => 'function() { return $("#date-range").val(); }',
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
        $columns = [];

        if ($this->canShowAction()) {
            $columns[] = Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center');
        }

        $columns = array_merge($columns, [
            Column::make('name'),
            Column::make('email'),
            Column::computed('roles')->addClass('text-center'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ]);

        return $columns;
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }

    protected function canShowAction(): bool
    {
        return auth()->user()->can('edit_users') || auth()->user()->can('delete_users');
    }
}
