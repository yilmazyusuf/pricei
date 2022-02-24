@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')
    <script src="{{ asset('storage/template/dist-assets/js/charts.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTabProduct', $(e.target).attr('href'));
            });
            var activeTabPr = localStorage.getItem('activeTabProduct');
            if (activeTabPr) {
                $('#product_detail_tab a[href="' + activeTabPr + '"]').tab('show');
            }
            $('#vendors-icon-tab').on('shown.bs.tab', function (e) {
                charts.vendorPriceChange({!! $productPriceChart['source'] !!},{!! $productPriceChart['dimensions'] !!},{!! $productPriceChart['series'] !!});
            })

            $('#product_tab').on('shown.bs.tab', function (e) {
                showProductPriceChangeChart();
            })

            showProductPriceChangeChart();

        });

        function showProductPriceChangeChart(){

        }


    </script>
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Ürün Detay</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" id="product_detail_tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product_tab" data-toggle="tab" href="#tab_home" role="tab"
                       aria-controls="tab_home" aria-selected="true">
                        <i class="nav-icon i-Box-Full mr-1"></i>Ürün
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="vendors-icon-tab" data-toggle="tab" href="#tab_vendors" role="tab"
                       aria-controls="tab_vendors" aria-selected="false">
                        <i class="nav-icon i-Clothing-Store mr-1"></i> Günlük Değişim
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab"
                       aria-controls="contactIcon" aria-selected="false">
                        <i class="nav-icon i-Clock mr-1"></i> Diğer Platformlar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab"
                       aria-controls="contactIcon" aria-selected="false">
                        <i class="nav-icon i-Clock mr-1"></i> Alarmlar
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myIconTabContent">
                @include('products.detail_tabs.product_summary')
                @include('products.detail_tabs.vendors')
                @include('products.detail_tabs.alarms')
            </div>


        </div>
    </div>

    <!-- end of main-content -->

@endsection
