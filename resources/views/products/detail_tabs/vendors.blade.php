@push('scripts')
    {{$productHistoryDataTable->html()->scripts()}};

    <script>
        $(document).ready(function () {

            $('.form-check-input').on('click', function (e) {
                if ($(this).is(':checked')) {
                    $(this).closest('li').addClass('active');
                } else {
                    $(this).closest('li').removeClass('active');
                }
            })

            $('#datepicker_product_price_chart').datepicker({
                format: "dd.mm.yyyy",
                todayBtn: "linked",
                language: "tr"
            });

        });
        $('.price_history_detail').on('change',function () {

            reloadVendorsPriceHistory();
        });
        //productPriceChartEnd

        function reloadVendorsPriceHistory(){
            var data;
            data = new FormData();
            data.append( 'productPriceChartStart', $('input#productPriceChartStart').val() );
            data.append( 'updateDailyPage', true );
            laravel.ajax.send({
                url: '{{route('products.detail',$product->id)}}',
                data: data,
                type: 'POST',
                processData: false,
                contentType: false,
                async: true,
                success: function (payload) {

                }

            });
        }


    </script>
@endpush

<div class="tab-pane fade show active" id="tab_vendors" role="tabpanel" aria-labelledby="product_tab">
    <div class="card mb-4 o-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form>
                        <div class="form-group row">
                            <div class='col-sm-12'>
                                <div class="input-daterange input-group"
                                     id="datepicker_product_price_chart">
                                    <input type="text" readonly class="input-sm form-control price_history_detail"
                                           name="productPriceChartStart" id="productPriceChartStart"
                                           value="{{request('productPriceChartStart')}}"/>
                                    <input type="text" readonly class="input-sm form-control price_history_detail"
                                           name="productPriceChartEnd"
                                           value="{{request('productPriceChartEnd')}}" id="productPriceChartEnd"/>
                                    <div class="input-group-append"><span
                                            class="input-group-text"><i
                                                class="fa fa-calendar"></i></span></div>

                                </div>
                            </div>
                        </div>
                        <fieldset class="form-group row">

                            <div class="col-sm-12">
                                <div class="form-check pl-0">
                                    <label class="checkbox checkbox-primary price_history_detail">
                                        <input type="checkbox"
                                               checked="checked"/><span>Fiyat artışı olan günleri göster</span><span
                                            class="checkmark"></span>
                                    </label>

                                </div>
                                <div class="form-check pl-0">
                                    <label class="checkbox checkbox-primary price_history_detail">
                                        <input type="checkbox" checked="checked"/><span>Fiyat düşüşü olan  günleri göster</span><span
                                            class="checkmark "></span>
                                    </label>
                                </div>
                                <div class="form-check pl-0">
                                    <label class="checkbox checkbox-primary price_history_detail">
                                        <input type="checkbox"
                                               checked="checked"/><span>Tüm günleri göster</span><span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                    <ul class="list-group">
                        @foreach($sortedHistoryByName as $history)

                            <li class="list-group-item">
                                <label class="checkbox checkbox-outline-primary mb-0">

                                    <input type="checkbox" class="form-check-input price_history_detail"
                                           name="vendorPrice[{{$history['id']}}]"><span>{{$history['sellerName']}}</span><span
                                        class="checkmark"></span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-tabs" id="priceHistoryTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="vendors-chart-pill" data-toggle="tab"
                                                href="#chart_tab_vendors" role="tab" aria-controls="chart_tab_vendors"
                                                aria-selected="true"><i
                                    class="nav-icon i-Line-Chart mr-1"></i>Grafik</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="vendors-list-pill" data-toggle="tab"
                                                href="#list_tab_vendors" role="tab" aria-controls="list_tab_vendors"
                                                aria-selected="false"><i class="nav-icon i-Receipt mr-1"></i>
                                Liste</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="chart_tab_vnd">
                        <div class="tab-pane fade show active" id="chart_tab_vendors" role="tabpanel"
                             aria-labelledby="vendors-chart-pill">
                            <div id="vendors_chart" style="height: 400px;"></div>
                        </div>
                        <div class="tab-pane fade" id="list_tab_vendors" role="tabpanel"
                             aria-labelledby="vendors-list-pill">
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


