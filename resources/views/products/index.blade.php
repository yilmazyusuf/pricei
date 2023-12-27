@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {{$dataTable->scripts()}}
    <script>
        $(document).ready(function () {

            var tb = $('#product_categories-table').DataTable();

            $("div.data_table_toolbar").html('{!! preg_replace( "/\r|\n/", "", trim(view('filters.products_index')) ); !!}');

            $('#isJobActive').change(function () {
                tb.draw();
            });

            $('.select2').select2({
                placeholder: "Platform",
                allowClear: true
            });

            $(document.body).on("change","#platform_id",function(){
                tb.draw();
            });

        });
    </script>
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Fiyat Takibi Yapılan Ürünler</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{$dataTable->table(['class' => 'table table-bordered table-hover w-100'])}}
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- end of main-content -->

@endsection
