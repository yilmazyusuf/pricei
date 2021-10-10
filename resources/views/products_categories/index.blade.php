@extends('layouts.layout')
@section('meta.title', 'Products ›› Categories')
@push('scripts')
    <script>
        DataTable.getProductCategories('{{route('products_categories.index.data_table')}}');
    </script>
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Products</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Products</a></li>
            <li>Categories</li>
        </ul>

        <a class="btn btn-primary btn-icon" role="button" href="{{route('products_categories.create')}}"
           title="Create Category" style="margin-left: auto">
            <i class="far fa-plus-square"></i> Create Category
        </a>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-hover" id="data_table"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- end of main-content -->

@endsection
