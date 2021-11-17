@extends('layouts.layout')
@section('meta.title', 'Products ›› Categories ›› Update')

@push('scripts')
    <script>



        $('.select2').select2({
            placeholder: "Select parent category",
            allowClear: true
        });

        $("#product_category_update").jsonToForm( @json($collection));
    </script>
@endpush

@section('content')
    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Update Category</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Products</a></li>
            <li><a href="{{route('products_categories.index')}}">Categories</a></li>
            <li>Create</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <form class="ajax" id="product_category_update" action="{{route('products_categories.update',$collection->id)}}" method="post">
                @method('put')
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">Category Name</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="name" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="parent">Parent Category</label>
                            <div class="col-sm-4">
                                <x-select2 :selectItem="$categoriesComponent"/>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-light" href="{{route('products_categories.index')}}">Cancel</a>
                        <button class="btn btn-primary ajax_btn " type="submit">Update Category</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
