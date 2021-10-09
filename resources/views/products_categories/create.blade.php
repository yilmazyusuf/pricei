@extends('layouts.layout')
@section('meta.title', 'Create Category')

@push('scripts')
    <script>
        $('.select2').select2({
            placeholder: "Select parent category",
            allowClear: true
        });
    </script>
@endpush

@section('content')
    <div class="breadcrumb justify-content-between align-items-center" style="flex-direction: row">
        <h1 class="mr-2">Create Category</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <form class="ajax" action="{{route('products_categories.store')}}" method="post">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">Category Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="parent">Parent Category</label>
                            <div class="col-sm-10">
                                <x-select2 :selectItem="new \App\View\Components\Form\SelectProductCategories()"/>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary ajax_btn" type="submit">Create Category</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
