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
    <script src="{{ asset('storage/template/dist-assets/js/charts.js') }}"></script>
    <script>
        $('#datepicker_product_price_chart').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "tr"
        });

        charts.productPriceChange({!! $productPriceChart['xAxis'] !!}, {!! $productPriceChart['yAxis'] !!})


    </script>
@endpush
<div class="tab-pane fade show active" id="homeIcon" role="tabpanel"
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 o-hidden">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Ürün Fiyat Değişimleri</h5>
                            <div class='col-sm-7 d-flex p-0 mb-4'>
                                <form>
                                    <div class="input-daterange input-group"
                                         id="datepicker_product_price_chart">
                                        <input type="text" class="input-sm form-control"
                                               name="productPriceChartStart"
                                               value="{{request('productPriceChartStart')??$productPriceChart['xAxis']->first()}}"/>
                                        <input type="text" class="input-sm form-control"
                                               name="productPriceChartEnd"
                                               value="{{request('productPriceChartEnd')??$productPriceChart['xAxis']->last()}}"/>
                                        <div class="input-group-append"><span
                                                class="input-group-text"><i
                                                    class="fa fa-calendar"></i></span></div>
                                        <button class="btn btn-outline-primary ml-2">Filitrele
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <ul class="nav nav-tabs" id="priceHistoryTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="home-icon-pill" data-toggle="tab"
                                                        href="#chart_tab" role="tab" aria-controls="chart_tab"
                                                        aria-selected="true"><i class="nav-icon i-Line-Chart mr-1"></i>Grafik</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="profile-icon-pill" data-toggle="tab"
                                                        href="#list_tab" role="tab" aria-controls="list_tab"
                                                        aria-selected="false"><i class="nav-icon i-Receipt mr-1"></i>
                                        Liste</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myPillTabContent">
                                <div class="tab-pane fade show active" id="chart_tab" role="tabpanel"
                                     aria-labelledby="home-icon-pill">
                                    <div id="products_chart" style="height: 400px;"></div>
                                </div>
                                <div class="tab-pane fade" id="list_tab" role="tabpanel"
                                     aria-labelledby="profile-icon-pill">
                                    <div class="table-responsive">
                                        {{$productHistoryDataTable->html()->table(['class' => 'table table-bordered table-hover w-100'])}}
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
