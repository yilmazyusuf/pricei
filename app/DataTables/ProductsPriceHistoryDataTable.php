<?php

namespace App\DataTables;

use App\Http\Filters\ProductsFilter;
use App\Http\Filters\ProductsPriceHistoryChartFilter;
use App\Http\Transformers\ProductsPriceHistoryTransformer;
use App\Http\Transformers\ProductsTransformer;
use App\Repositories\ProductsRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsPriceHistoryDataTable extends DataTable
{

    public function __construct(private Collection $collection)
    {
    }

    protected $dataTableVariable = 'priceHistoryDataTable';
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
            ->setTransformer(new ProductsPriceHistoryTransformer());
    }


    public function query(): Collection
    {
        return $this->collection;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('product_price_history-table')
            ->orders([])
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'priceHistoryDataTable' => 1
            ])
            ->dom('Bfrtip')
            ->buttons(
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
            Column::make('trackedDate')->title('Tarih'),
            Column::make('realPrice')->title('Liste Fiyatı'),
            Column::make('price')->title('Satış Fiyatı'),
            Column::make('changePercent')->title('Değişim Oranı'),
            Column::make('changeDiff')->title('Değişim Farkı'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ProductPriceHistories_' . date('YmdHis');
    }
}
