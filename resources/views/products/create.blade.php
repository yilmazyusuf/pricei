@extends('layouts.layout')
@section('meta.title', 'Ürünler ›› Yeni Ürün')

@push('scripts')
    <script>
              $('#exampleModalCenter').modal('show');
    </script>
@endpush

@section('content')
    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Yeni Ürün Fiyat Takibi</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Ürünler</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">

            <div class="card mb-5">
                <div class="card-body">
                    <div class="form-group row justify-content-md-center">
                        <div class="col-sm-6">
                            <form class="ajax" action="{{route('products.scrape')}}" method="post">
                                <div class="input-group">
                                    <input type="url" class="form-control"
                                           placeholder="Örnek : https://www.n11.com/urun/nokian-uretim-2361933"
                                           name="scrape_url" id="scrape_url">
                                    <div class="input-group-append">
                                        <button class="btn btn-raised btn-raised-primary ajax_btn" id="scrape_product"
                                                type="submit">Ürünü Getir
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>


            </div>


        </div>

    </div>

@endsection
