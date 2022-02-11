@extends('layouts.layout')
@section('meta.title', 'Platformlar ››  Güncelle')

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('button-image').addEventListener('click', (event) => {
                event.preventDefault();

                window.open('/file-manager/fm-button?leftDisk=platform_images&rightDisk=platform_images', 'fm', 'width=966,height=600');
            });
        });

        // set file link
        function fmSetLink($url) {
            document.getElementById('logo_url').value = $url;
        }


        $("#platform_update").jsonToForm( @json($collection));
    </script>
@endpush

@section('content')
    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Platform Güncelle</h1>
        <ul>
            <li><a href="{{route('platforms.index')}}">Platformlar</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <form class="ajax" id="platform_update" action="{{route('platforms.update',$collection->id)}}" method="post">
                @method('put')
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">İsim</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="name" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="url">Adres</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="url" type="url" name="url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="domains">Ürün Domainleri</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="domains" type="text" name="domains">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="logo_url">Logo</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" id="logo_url" class="form-control" name="logo_url"
                                           aria-label="Image" aria-describedby="button-image" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-light " type="button" id="button-image">Seçiniz</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" ></label>
                            <div class="col-sm-4">
                                <img src='{{asset($collection->logo_url)}}' height=50>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-light" href="{{route('platforms.index')}}">İptal Et</a>
                        <button class="btn btn-primary ajax_btn " type="submit">Güncelle</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
