@extends('layouts.layout')
@section('meta.title', 'Ürünler ›› Yeni Ürün')

@push('scripts')
    <script>
              $('#exampleModalCenter').modal('show');
    </script>
@endpush

@section('content')
    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Fiyat Takibi Oluştur</h1>
        <ul>
            <li><a href="{{route('products.index')}}">Ürünler</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <form class="ajax" action="{{route('products.scrape')}}" method="post">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="scrape_url">Ürün Linki</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control" name="scrape_url" id="scrape_url" type="url" placeholder="Örnek : https://www.n11.com/urun/nokian-uretim-2361933">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-light" href="{{route('products.index')}}">İptal</a>
                    <button class="btn btn-raised btn-raised-primary ajax_btn" id="scrape_product"
                            type="submit">Ürünü Getir
                    </button>
                </div>


            </div>
            </form>


        </div>

    </div>

@endsection
