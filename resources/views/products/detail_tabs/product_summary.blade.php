@php
    $minPriceVendor = $product->vendors->sortBy('price')->first();
    $maxPriceVendor = $product->vendors->sortByDesc('price')->first();
@endphp
@push('scripts')
    {{$productHistoryDataTable->html()->scripts()}};
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#priceHistoryTab a[href="' + activeTab + '"]').tab('show');

            }
        });
    </script>

    <script>
        $('#datepicker_product_price_chart').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "tr"
        });


    </script>
@endpush
<style>
    .card-icon-bg .card-body .content{
        max-width: none;!important;
    }
</style>
<div class="tab-pane fade show active" id="tab_home" role="tabpanel"
     aria-labelledby="home-icon-tab">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 o-hidden">
                <div class="card-body text-center">
                    <div class="avatar mb-3">
                        <img class="card-img-top" src="{{$product->imageUrl}}" alt=""
                             style="width: 60%">
                    </div>
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">
                        <del>{{priceWithCurrency($product->realPrice)}}</del>
                    </p>
                    <h5 class="card-title">{{priceWithCurrency($product->price)}}</h5>
                    <p class="card-text">{{$product->sellerName}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @if($lastPriceUpdate)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Önceki Fiyat
                            <h5 class="m-0 ml-auto">
                     <span
                         class="badge badge-pill badge-outline-primary ">{{priceWithCurrency($lastPriceUpdate->price - $lastPriceUpdate->pricePreviousDiff)}}</span>
                            </h5>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fiyat Değişim Oranı
                            <h5 class="m-0 ml-auto">
                     <span class="badge badge-pill badge-outline-primary ">
                     {!! $lastPriceUpdate->priceDiffPercentWithIcon !!}
                     </span>
                            </h5>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fiyat Değişim Miktarı
                            <h5 class="m-0 ml-auto">
                     <span class="badge badge-pill badge-outline-primary ">
                     {!! $lastPriceUpdate->priceDiffWithIcon !!}
                     </span>
                            </h5>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fiyat Değişim Tarihi
                            <h5 class="m-0 ml-auto">
                     <span class="badge badge-pill badge-outline-primary ">
                     {{$lastPriceUpdate->trackedDate}}
                     </span>
                            </h5>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Son Güncellenme Tarihi
                        <h5 class="m-0 ml-auto">
                     <span class="badge badge-pill badge-outline-primary">
                     {{$product->updated_at->format('d.m.Y')}}
                     </span>
                        </h5>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">

            @if($minPriceVendor)
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
                    <div class="card card-profile-1 mb-0">
                        <div class="card-body p-0">
                            <div class="tabl
                            e-responsive">
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
    @endif
        </div>
    </div>
</div>
