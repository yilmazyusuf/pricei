@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTabProduct', $(e.target).attr('href'));
            });
            var activeTabPr = localStorage.getItem('activeTabProduct');
            if (activeTabPr) {
                $('#product_detail_tab a[href="' + activeTabPr + '"]').tab('show');
            }


            let vendors_chart = charts.vendorPriceChange({!! $productWithVendorsPriceChart['source'] !!},{!! $productWithVendorsPriceChart['dimensions'] !!},{!! $productWithVendorsPriceChart['series'] !!});
            let product_chart = charts.productPriceChange({!! $productPriceChart['xAxis'] !!}, {!! $productPriceChart['yAxis'] !!})

            $('#product_tab').on('shown.bs.tab', function (e) {
                product_chart.resize();
            })
            $('#vendors-icon-tab').on('shown.bs.tab', function (e) {
                vendors_chart.resize();
            })
        });

    </script>
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Ürün Detay</h1>
        <ul>
            <li>{{$product->name}}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" id="product_detail_tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " id="product_tab" data-toggle="tab" href="#tab_home" role="tab"
                       aria-controls="tab_home" aria-selected="true">
                        <i class="nav-icon i-Money-2 mr-1"></i>Güncel Fiyatlar
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" id="vendors-icon-tab" data-toggle="tab" href="#tab_vendors" role="tab"
                       aria-controls="tab_vendors" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i> Günlük Fiyatlar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab"
                       aria-controls="contactIcon" aria-selected="false">
                        <i class="nav-icon i-Clock mr-1"></i> Alarmlar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab"
                       aria-controls="contactIcon" aria-selected="false">
                        <i class="nav-icon i-Clock mr-1"></i> Bildirimler
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
