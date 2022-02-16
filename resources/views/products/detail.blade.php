@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')
    <script src="{{ asset('template/dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('template/dist-assets/js/plugins/calendar/moment.min.js') }}"></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('template/dist-assets/js/plugins/calendar/tempus-dominus.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/dist-assets/js/plugins/calendar/tempus-dominus.css') }}">

    <script>
        const linkedPicker1Element = document.getElementById('linkedPickers1');
        const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
        const linked2 = new tempusDominus.TempusDominus(document.getElementById('linkedPickers2'), {
            useCurrent: false
        });

        //using event listeners
        linkedPicker1Element.addEventListener(tempusDominus.Namespace.events.change, (e) => {
            linked2.updateOptions({
                restrictions: {
                    minDate: e.detail.date
                }
            });
        });

        //using subscribe method
        const subscription = linked2.subscribe(tempusDominus.Namespace.events.change, (e) => {
            linked1.updateOptions({
                restrictions: {
                    maxDate: e.date
                }
            });
        });

        // event listener can be unsubscribed to:
        // subscription.unsubscribe();



        var basicLineElem = document.getElementById('basicLine');

        if (basicLineElem) {
            var basicLine = echarts.init(basicLineElem);
            basicLine.setOption({
                tooltip: {
                    show: true,
                    trigger: 'axis',
                    axisPointer: {
                        type: 'line',
                        animation: true
                    }
                },
                grid: {
                    top: '10%',
                    left: '40',
                    right: '40',
                    bottom: '40'
                },
                xAxis: {
                    type: 'category',
                    data: ['1/11/2018', '2/11/2018', '3/11/2018', '4/11/2018', '5/11/2018', '6/11/2018', '7/11/2018', '8/11/2018', '9/11/2018', '10/11/2018', '11/11/2018', '12/11/2018', '13/11/2018', '14/11/2018', '15/11/2018', '16/11/2018', '17/11/2018', '18/11/2018', '19/11/2018', '20/11/2018', '21/11/2018', '22/11/2018', '23/11/2018', '24/11/2018', '25/11/2018', '26/11/2018', '27/11/2018', '28/11/2018', '29/11/2018', '30/11/2018'],
                    axisLine: {
                        show: false
                    },
                    axisLabel: {
                        show: true
                    },
                    axisTick: {
                        show: false
                    }
                },
                yAxis: {
                    type: 'value',
                    axisLine: {
                        show: false
                    },
                    axisLabel: {
                        show: true
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        show: true
                    }
                },
                series: [{
                    data: [400, 800, 325, 900, 700, 800, 400, 900, 800, 800, 300, 405, 500, 1100, 900, 1450, 1200, 1350, 1200, 1400, 1000, 800, 950, 705, 690, 921, 1020, 903, 852, 630],
                    type: 'line',
                    showSymbol: true,
                    smooth: true,
                    color: '#639',
                    lineStyle: {
                        opacity: 1,
                        width: 2
                    }
                } // {
                    //     data: [100, 400, 225, 800, 550, 860, 300, 400, 1200, 200, 1300, 1405, 900, 500, 1100, 850, 1200, 1150, 1200, 500, 800, 400, 750, 905, 690, 921, 1020, 903, 852, 630],
                    //     type: 'line',
                    //     showSymbol: true,
                    //     smooth: true,
                    //     lineStyle: {
                    //         opacity: 1,
                    //         width: 2,
                    //     },
                    // }
                ]
            });
            $(window).on('resize', function () {
                setTimeout(function () {
                    basicLine.resize();
                }, 500);
            });
        }
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
                                                    <div class="card-title">Son 30 Fiyat Değişimi</div>

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
                                                    <div id="basicLine" style="height: 300px;"></div>
                                                </div>
                                            </div>
                                        </div>

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
                                                            <td>10% <i class="i-Turn-Down-2 text-14 text-danger font-weight-700"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>10.01.2022</td>
                                                            <td>550 TL</td>
                                                            <td>10% <i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
