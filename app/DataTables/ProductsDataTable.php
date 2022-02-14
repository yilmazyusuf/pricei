<?php

namespace App\DataTables;

use App\Http\Transformers\ProductsTransformer;
use App\Repositories\ProductsRepository;
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
        return ProductsRepository::get();
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
                'defaultContent' => '<button class="btn btn-raised btn-raised-secondary" type="button"><span class="ul-btn__icon"><i class="nav-icon i-Line-Chart"></i></span><span class="ul-btn__text"> Detay</span></button>',
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
                Button::make('reload')->className('btn-raised btn-raised-secondary'),
                Button::make('print')->className('btn-raised btn-raised-secondary'),
                Button::make('export')->className('btn-raised btn-raised-secondary')
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
            Column::make('imageUrl')
                ->title('')
                ->searchable(false)
                ->orderable(false),
            Column::make('name')->title('İsim')->width(350),
            Column::make('realPrice')->title('Liste Fiyatı'),
            Column::make('price')->title('Satış Fiyatı'),
            //Column::make('changeRatio')->title('Değişim Oranı'),
            //Column::make('changeDiff')->title('Değişim Farkı'),
            Column::make('platform.name', 'platform.name')->title('Platform'),
            Column::make('updated_at', 'updated_at')->title('Son Güncelleme'),


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
