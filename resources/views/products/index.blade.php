@extends('layouts.index')
@section('meta.title', 'Products')
@section('content')
    <div class="breadcrumb justify-content-between align-items-center" style="flex-direction: row">
        <h1 class="mr-2">Products</h1>


        <a class="btn btn-primary btn-icon lata-btn" role="button" href="{{route('products.create')}}" title="Create Category">
            <i class="far fa-plus-square"></i> Create Product
        </a>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">test</div>
    </div>
@endsection
