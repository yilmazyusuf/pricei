@section('modal_section')
    <div class="modal fade" id="product_scraped_preview_modal" role="dialog"
         aria-labelledby="product_scraped_preview_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="product_scraped_preview_modal">{!! $product->name !!}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-0">
                    <div class="card card-profile-1 mb-0">
                        <div class="card-body text-center">
                            <div class="avatar mb-3" style="width: 160px; height: 160px">
                                <img src="{{$product->imageUrl}}" alt=""></div>
                            @if($product->price->realPrice)
                                <del class="m-0">{{$product->price->realPrice}} TL</del>
                            @endif
                            <h2 class="m-0">{{$product->price->price}} TL</h2>

                            <p class="mt-0">{{$product->seller->name}}</p>

                            <button class="btn btn-primary btn-rounded">Fiyatını Takip Et</button>
                        </div>

                        @if(count($product->competingVendors) > 0)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-gray-200">
                                    Diğer Mağazalardaki Fiyatlar
                                </li>
                                @foreach($product->competingVendors as $vendor)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$vendor->seller->name}}
                                        @if($vendor->price->realPrice)
                                            <del
                                                style="margin-left: auto;margin-right: 5px;">{{$vendor->price->realPrice}}
                                                TL
                                            </del>
                                        @endif
                                        <h4>
                                        <span
                                            class="badge badge-pill badge-light">{{$vendor->price->price}} TL</span>
                                        </h4>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
