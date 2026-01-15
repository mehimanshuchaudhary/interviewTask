<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Product> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query);
        
        if ($this->canShowAction()) {
            $dataTable->addColumn('action', function ($row) {
                return view('utilities.crm-action-buttons', [
                    'edit_url'   => auth()->user()->can('edit_product')
                                    ? route('products.edit', $row->id)
                                    : null,

                    'delete_url' => auth()->user()->can('delete_product')
                                    ? route('products.destroy', $row->id)
                                    : null,
                ]);
            });
        }

        return $dataTable
            ->editColumn('price', fn ($row) => number_format($row->price, 2))
            ->editColumn('created_at', fn ($row) => $row->created_at->format('d-m-Y'))
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Product>
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
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

        if (auth()->user()->can('create_product')) {
            $buttons[] = Button::raw('add')
                ->text('+ Add Product')
                ->attr(['class' => 'btn btn-success'])
                ->action('function (e, dt, node, config) {
                    window.location.href = "' . route('products.create') . '";
                }');
        }

        return $this->builder()
                    ->setTableId('products-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(4, 'desc') // Sort by Created At
                    ->selectStyle('os')
                    ->responsive(true)
                    ->scrollX(true)
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
            Column::make('description')->visible(false), // Hidden by default, viewable via colvis
            Column::make('price'),
            Column::make('stock'),
            Column::make('created_at'),
        ]);

        return $columns;
    }

    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }

    protected function canShowAction(): bool
    {
        return auth()->user()->can('edit_product') || auth()->user()->can('delete_product');
    }
}
