@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Ürün Detay</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="product_detail_tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#homeIcon" role="tab"
                               aria-controls="homeIcon" aria-selected="true">
                                <i class="nav-icon i-Box-Full mr-1"></i>Ürün
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#profileIcon" role="tab"
                               aria-controls="profileIcon" aria-selected="false">
                                <i class="nav-icon i-Clothing-Store mr-1"></i> Mağazalar
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


        </div>
    </div>

    <!-- end of main-content -->

@endsection
