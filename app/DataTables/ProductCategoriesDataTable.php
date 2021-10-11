<?php

namespace App\DataTables;

use App\Http\Transformers\ProductCategoriesTransformer;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoriesRepository;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query): DataTableAbstract
    {
        return datatables()
            ->of($query)
            ->setTransformer(new ProductCategoriesTransformer());

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
            ->setTableId('productcategories-table')
            ->columns($this->getColumns())
            ->addAction([
                'defaultContent' => view('partials.datatable_action_buttons')->render(),
                'title' => '#',
                'width' => '10',
                'className' => 'dsdsad',
            ])

            ->minifiedAjax()
            ->dom('Bfrtip')
            ->buttons(
                Button::make('create'),
                Button::make('print'),
                Button::make('reload'),
                Button::make('export')
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
            Column::make('parent.name','parent.name')
                ->title('Parent'),

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
