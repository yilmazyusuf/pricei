@extends('layouts.index')
@section('meta.title', 'Products')
@section('content')
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            <div class="breadcrumb justify-content-between align-items-center" style="flex-direction: row">
                <h1 class="mr-2">Products</h1>

                <a class="btn btn-primary btn-icon rounded-0 lata-btn" role="button" href="{{route('products.create')}}" title="Add Product">
                    <span class="ul-btn__icon"><i class="i-Add"></i></span>
                    <span class="ul-btn__text">Add Product</span>
                </a>
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">test</div>
            </div>

            <!-- end of main-content -->
        </div>
        <x-layout.footer/>
    </div>
@endsection
