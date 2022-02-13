<?php

namespace App\DataTables;

use App\Http\Transformers\PlatformsTransformer;
use App\Repositories\PlatformsRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PlatformsDataTable extends DataTable
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
            ->setTransformer(new PlatformsTransformer());

    }


    public function query(): Collection
    {
        return PlatformsRepository::get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('platforms-table')
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
                Button::make('create')->text('<i class="fa fa-plus"></i> Platform Ekle')
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
            Column::make('name')->title('Platform'),
            Column::make('logo_url')->title('Logo')
                ->searchable(false)
                ->orderable(false),
            Column::make('url')->title('Adres'),
            Column::make('domains')->title('Domainler')

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Platforms_' . date('YmdHis');
    }
}
