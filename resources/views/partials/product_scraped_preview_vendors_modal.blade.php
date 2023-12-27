@php
    $minPriceVendor = $product->vendors->sortBy('price')->first();
    $maxPriceVendor = $product->vendors->sortByDesc('price')->first();
@endphp

@section('modal_section')
    <style>
        .card-icon-bg .card-body .content{
            max-width: none;!important;
        }
    </style>
    <div class="modal fade bd-example-modal-lg" id="product_scraped_preview_modal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="product_scraped_preview_modal">{!! $product->name !!}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                    <div class="card-body text-center"><i class="i-Down"></i>
                                        <div class="content">
                                            <p class="text-muted mt-0 mb-0">En Düşük Fiyat</p>
                                            <p class="text-muted mt-0 mb-1 text-10">{{$minPriceVendor->sellerName}}</p>
                                            <p class="lead text-primary text-24 mb-0">

                                                {{priceWithCurrency((int)$minPriceVendor->price)}}
                                                </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                    <div class="card-body text-center"><i class="i-Up"></i>
                                        <div class="content">
                                            <p class="text-muted mt-0 mb-0">En Yüksek Fiyat</p>
                                            <p class="text-muted mt-0 mb-1 text-10">{{$maxPriceVendor->sellerName}}</p>
                                            <p class="lead text-primary text-24 mb-0">
                                                {{priceWithCurrency((int)$maxPriceVendor->price)}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                    <div class="card-body text-center"><i class="i-Money-2"></i>
                                        <div class="content">
                                            <p class="text-muted mt-2 mb-0">Ortalama Fiyat</p>
                                            <p class="lead text-primary text-24 mb-2">
                                                {{priceWithCurrency((int)$product->vendors->median('price'))}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>Ürünün fiyatını ve diğer satıcıların fiyatlarını takip etmek için tıklayınız.</p>
                                        <form class="ajax" action="{{route('products.track',[$product->id])}}"
                                              method="post">

                                            <button class="btn btn-primary ajax_btn" type="submit">Tüm Fiyatları
                                                Takip Et
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card card-profile-1 mb-0">
                                    <div class="card-body text-center" style="height: 300px">

                                        <div class="avatar mb-3" style="width: auto; height: auto">
                                            <img src="{{$product->imageUrl}}" alt="" height="175"></div>
                                        @if($product->price && $product->realPrice > $product->price)
                                            <del class="m-0">{{priceWithCurrency($product->realPrice)}}</del>
                                        @endif
                                        <h2 class="m-0">{{priceWithCurrency($product->price)}}</h2>

                                        <p class="mt-0">{{$product->sellerName}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card card-profile-1 mb-0">
                                    <div class="card-body p-0" style="overflow: auto; height: 300px">
                                        <div class="table-responsive">
                                            <table class="table table-hover w-100">
                                                <thead>
                                                <tr>
                                                    <th>Mağaza</th>
                                                    <th>Liste Fiyatı</th>
                                                    <th>Satış Fiyatı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($product->vendors->sortBy('price') as $vendor)
                                                    <tr>
                                                        <td>{{$vendor->sellerName}}</td>
                                                        <td>
                                                            @if($vendor->realPrice && $vendor->price < $vendor->realPrice)
                                                                <del style="margin-left: auto;margin-right: 5px;">
                                                                    {{priceWithCurrency($vendor->realPrice)}}
                                                                </del>
                                                            @endif
                                                        </td>
                                                        <td>{{priceWithCurrency($vendor->price)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
