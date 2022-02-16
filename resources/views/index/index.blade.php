@extends('layouts.layout')
@section('meta.title', 'Fiyat Takibi Yapılan Ürünler')
@push('scripts')

@endpush
@section('content')



    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content" style="max-width: none">
                        <p class="text-muted mt-2 mb-0">Takip edilen ürün adedi</p>
                        <p class="lead text-primary text-24 mb-2">75 / 100</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="progress mb-1">
                        <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">%25</div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end of main-content -->

@endsection

