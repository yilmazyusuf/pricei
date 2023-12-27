@push('scripts')

    <script>

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "currency-pre": function (a) {
                a = (a === "-") ? 0 : a.replace(/[^\d\-\.]/g, "");
                return parseFloat(a);
            },

            "currency-asc": function (a, b) {
                return a - b;
            },

            "currency-desc": function (a, b) {
                return b - a;
            }
        });

        $(function () {
            $('.current_price_history_DataTable').DataTable({
                processing: true,
                "order": [[4, "asc"]],
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tümü"]],
                columnDefs: [
                    {type: 'currency', targets: 3},
                ],

            });
        });

    </script>
@endpush
<style>
    .card-icon-bg .card-body .content {
        max-width: none;
    !important;
    }
</style>
<div class="tab-pane fade" id="tab_home" role="tabpanel"
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
                    <p class="card-text"><img src="{{$product->platform->logo_url}}" height="36"></p>
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="actual_price_tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="price_product_tab_id" data-toggle="tab"
                       href="#price_product_tab_href"
                       role="tab"
                       aria-controls="price_product_tab_href" aria-selected="true">
                        <i class="nav-icon i-Box-Full mr-1"></i>Ürün
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="price_vendor_tab_id" data-toggle="tab" href="#price_vendor_tab_href"
                       role="tab"
                       aria-controls="price_vendor_tab_href" aria-selected="true">
                        <i class="nav-icon i-Shop-4 mr-1"></i>Mağazalar
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="actual_price_tabs_contents">
                <div class="tab-pane fade show active" id="price_product_tab_href" role="tabpanel"
                     aria-labelledby="price_product_tab_id">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Money-2"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-1">Güncel Fiyat</p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {{priceWithCurrency($product->price)}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Previous"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-1">Önceki Fiyat</p>
                                        <p class="text-muted mt-0 mb-1 text-10">
                                            {{$lastPriceUpdate->trackedDate ?? '-'}}
                                        </p>
                                        <p class="lead text-primary text-24 mb-0">

                                            {{$lastPriceUpdate ? priceWithCurrency($lastPriceUpdate->price - $lastPriceUpdate->pricePreviousDiff) :'-'}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Pie-Chart-2"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-1">Fiyat Değişim Oranı</p>
                                        <p class="text-muted mt-0 mb-1 text-10">
                                            {{$lastPriceUpdate->trackedDate ?? '-'}}
                                        </p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {!! $lastPriceUpdate->priceDiffPercentWithIcon ?? '-' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Line-Chart"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-1">Fiyat Değişim Miktarı</p>
                                        <p class="text-muted mt-0 mb-1 text-10">
                                            {{$lastPriceUpdate->trackedDate ?? '-'}}
                                        </p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {!! $lastPriceUpdate->priceDiffWithIcon ?? '-' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Calendar-3"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-1">Son Güncelleme</p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {{$product->updated_at->format('d.m.Y')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div id="products_chart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show" id="price_vendor_tab_href" role="tabpanel"
                     aria-labelledby="price_vendor_tab_id">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Money-2"></i>
                                    <div class="content">
                                        <p class="text-muted mt-2 mb-0">Ortalama Fiyat</p>
                                        <p class="lead text-primary text-24 mb-2">
                                            {{priceWithCurrency((int)$actualPriceHistory->median('price'))}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Down"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-0">En Düşük Fiyat</p>
                                        @php
                                            $minPrice = $actualPriceHistory->sortBy('price')->first();
                                        @endphp
                                        <p class="text-muted mt-0 mb-1 text-10">
                                            {{$minPrice->sellerName }}
                                        </p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {{priceWithCurrency((int)$minPrice->price)}}
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
                                        @php
                                            $maxPrice = $actualPriceHistory->sortByDesc('price')->first();
                                        @endphp
                                        <p class="text-muted mt-0 mb-1 text-10">
                                            {{$maxPrice->sellerName }}
                                        </p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {{priceWithCurrency((int)$maxPrice->price)}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Line-Chart"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-0">Ortalama Fiyat Değişim Miktarı</p>
                                        <p class="lead text-primary text-24 mb-0">

                                            {!! \App\Models\PriceHistories::collectedPriceDiff($actualPriceHistory) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Pie-Chart-2"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-0">Ortalama Fiyat Değişim Oranı</p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {!! \App\Models\PriceHistories::collectedPriceDiffPercent($actualPriceHistory) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                                <div class="card-body text-center"><i class="i-Calendar-3"></i>
                                    <div class="content">
                                        <p class="text-muted mt-0 mb-0">Son Güncelleme</p>
                                        <p class="lead text-primary text-24 mb-0">
                                            {{$maxPrice->trackedDate}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-profile-1">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover w-100 current_price_history_DataTable">
                                            <thead>
                                            <tr>
                                                <th>Mağaza</th>
                                                <th>Önceki Fiyat</th>
                                                <th>Liste Fiyatı</th>
                                                <th>Güncel Fiyat</th>
                                                <th>Değişim Oranı</th>
                                                <th>Değişim Miktarı</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($actualPriceHistory->sortBy('price') as $history)
                                                <tr>
                                                    <td>{{$history->sellerName}}</td>
                                                    <td>{!! priceWithCurrency($history->price - $history->pricePreviousDiff) !!}</td>
                                                    <td>
                                                        <del>{!! priceWithCurrency($history->realPriceCompared) !!}</del>
                                                    </td>
                                                    <td>{!! priceWithCurrency($history->price) !!}</td>
                                                    <td>{!! $history->priceDiffPercentWithIcon !!}</td>
                                                    <td>{!! $history->priceDiffWithIcon !!}</td>
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
