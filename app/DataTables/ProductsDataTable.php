<?php

namespace App\DataTables;

use App\Http\Transformers\ProductsTransformer;
use App\Repositories\ProductCategoriesRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param Collection|null $query Results from query() method.
     * @return DataTableAbstract
     * @throws Exception
     */
    public function dataTable(?Collection $query): DataTableAbstract
    {
        return datatables()
            ->of($query)
            ->setTransformer(new ProductsTransformer());
    }


    public function query(): Collection
    {
        return ProductCategoriesRepository::get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('product_categories-table')
            ->columns($this->getColumns())
            ->addAction([
                'defaultContent' => view('partials.datatable_action_buttons')->render(),
                'title' => ' ',
                'width' => '10',
                'printable' => false,
            ])
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->buttons(
                Button::make('create')
                    ->text('<i class="fa fa-plus"></i> Ürün Ekle')
                    ->className('btn-primary'),
                Button::make('reload')->className('btn-outline-primary'),
                Button::make('print')->className('btn-outline-primary'),
                Button::make('export')->className('btn-outline-primary')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('name')->title('Name'),
            Column::make('parent.name', 'parent.name')
                ->title('Parent Category'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ProductCategories_' . date('YmdHis');
    }
}
