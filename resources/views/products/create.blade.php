@extends('layouts.layout')
@section('meta.title', 'Products ›› Create')

@push('scripts')
    <script>
        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true
        });
    </script>
@endpush

@section('content')
    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Create Product</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Products</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <ul class="nav nav-pills" id="myIconTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#homeIcon" role="tab" aria-controls="homeIcon" aria-selected="true"><i class="nav-icon i-Home1 mr-1"></i>Detail</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#profileIcon" role="tab" aria-controls="profileIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab" aria-controls="contactIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i> Contact</a></li>
            </ul>
            <div class="tab-content px-0" id="myIconTabContent">
                <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">
                    <form class="ajax" action="{{route('products.store')}}" method="post">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="name">Product Name</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" id="name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="parent">Category</label>
                                    <div class="col-sm-4">
                                        <x-select2 :selectItem="$categoriesComponent"/>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a class="btn btn-light" href="{{route('products.index')}}">Cancel</a>
                                <button class="btn btn-primary ajax_btn " type="submit">Create Product</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">
                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.

                </div>
                <div class="tab-pane fade" id="contactIcon" role="tabpanel" aria-labelledby="contact-icon-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.</div>
            </div>

        </div>

    </div>
@endsection
