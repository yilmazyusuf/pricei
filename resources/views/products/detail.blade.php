@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')

    <script src="{{ asset('storage/template/dist-assets/js/charts.js') }}"></script>
    <script>

        $('#datepicker').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "tr"
        });

        charts.productPriceChange({!! $productPriceChart['xAxis'] !!}, {!! $productPriceChart['yAxis'] !!})


    </script>
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Ürün Detay</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#homeIcon" role="tab"
                               aria-controls="homeIcon" aria-selected="true">
                                <i class="nav-icon i-Home1 mr-1"></i>Ürün
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="home-icon-tab" data-toggle="tab" href="#priceUpdates" role="tab"
                               aria-controls="homeIcon" aria-selected="true">
                                <i class="nav-icon i-Home1 mr-1"></i>Fiyat Değişimleri
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#profileIcon" role="tab"
                               aria-controls="profileIcon" aria-selected="false">
                                <i class="nav-icon i-Home1 mr-1"></i> Mağazalar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab"
                               aria-controls="contactIcon" aria-selected="false">
                                <i class="nav-icon i-Home1 mr-1"></i> Alarmlar
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myIconTabContent">
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
                                            <h5 class="card-title">{{$product->name}} TL</h5>
                                            <p class="card-text">
                                                <del>{{$product->realPrice}} TL</del>
                                            </p>
                                            <h5 class="card-title">{{$product->price}} TL</h5>
                                            <p class="card-text">{{$product->sellerName}}</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Önceki Fiyat</li>
                                            <li class="list-group-item">Fiyat Değişim Tarihi</li>
                                            <li class="list-group-item">Fiyat Değişim Oranı</li>
                                            <li class="list-group-item">Fiyat Değişim Miktarı</li>
                                            <li class="list-group-item">Son Güncelleme</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mb-4 o-hidden">
                                                <div class="card-body">
                                                    <form>
                                                    <div class='col-sm-7 d-flex'>
                                                        <div class="input-daterange input-group" id="datepicker">
                                                            <input type="text" class="input-sm form-control"
                                                                   name="productPriceChartStart" value="{{request('productPriceChartStart')??$productPriceChart['xAxis']->first()}}"/>
                                                            <input type="text" class="input-sm form-control"
                                                                   name="productPriceChartEnd" value="{{request('productPriceChartEnd')??$productPriceChart['xAxis']->last()}}"/>
                                                            <div class="input-group-append"><span
                                                                    class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></span></div>

                                                        </div>
                                                        <button class="btn btn-outline-primary ml-2">Filitrele</button>
                                                    </div>
                                                    </form>

                                                    <div id="products_chart" style="height: 300px;"></div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="priceUpdates" role="tabpanel"
                             aria-labelledby="home-icon-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <div class="card-title">Fiyat Güncellemeri</div>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <label for='linkedPickers1Input' class='form-label'>From</label>
                                                    <div
                                                        class='input-group log-event'
                                                        id='linkedPickers1'
                                                        data-td-target-input='nearest'
                                                        data-td-target-toggle='nearest'
                                                    >
                                                        <input
                                                            id='linkedPickers1Input'
                                                            type='text'
                                                            class='form-control'
                                                            data-td-target='#linkedPickers1'
                                                        />
                                                        <span
                                                            class='input-group-text'
                                                            data-td-target='#linkedPickers1'
                                                            data-td-toggle='datetimepicker'
                                                        >
		   <span class='fas fa-calendar'></span>
		 </span>
                                                    </div>
                                                </div>
                                                <div class='col-sm-6'>
                                                    <label for='linkedPickers2Input' class='form-label'>To</label>
                                                    <div
                                                        class='input-group log-event'
                                                        id='linkedPickers2'
                                                        data-td-target-input='nearest'
                                                        data-td-target-toggle='nearest'
                                                    >
                                                        <input
                                                            id='linkedPickers2Input'
                                                            type='text'
                                                            class='form-control'
                                                            data-td-target='#linkedPickers2'
                                                        />
                                                        <span
                                                            class='input-group-text'
                                                            data-td-target='#linkedPickers2'
                                                            data-td-toggle='datetimepicker'
                                                        >
		   <span class='fas fa-calendar'></span>
		 </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-hover w-100">
                                                <thead>
                                                <tr>
                                                    <th>Tarih</th>
                                                    <th>Fiyat</th>
                                                    <th>Değişim</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>+10%</td>
                                                </tr>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>+10%</td>
                                                </tr>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>+10%</td>
                                                </tr>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>+10%</td>
                                                </tr>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>10% <i
                                                            class="i-Turn-Down-2 text-14 text-danger font-weight-700"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10.01.2022</td>
                                                    <td>550 TL</td>
                                                    <td>10% <i
                                                            class="i-Turn-Up-2 text-14 text-success font-weight-700"></i>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">
                            Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic
                            lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork
                            tattooed craft beer, iphone skateboard locavore.

                        </div>
                        <div class="tab-pane fade" id="contactIcon" role="tabpanel" aria-labelledby="contact-icon-tab">
                            Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic
                            lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork
                            tattooed craft beer, iphone skateboard locavore.
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- end of main-content -->

@endsection
