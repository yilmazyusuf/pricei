@extends('layouts.layout')
@section('meta.title', 'Products ›› Categories')
@push('scripts')
    {{$dataTable->scripts()}}
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Product Categories</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Products</a></li>
            <li>Categories</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                {{$dataTable->table(['class' => 'table table-striped table-bordered table-hover w-100'])}}
            </div>


        </div>
    </div>

    <!-- end of main-content -->

@endsection
