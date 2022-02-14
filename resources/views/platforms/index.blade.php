@extends('layouts.layout')
@section('meta.title', 'Platformlar')
@push('scripts')
    {{$dataTable->scripts()}}
@endpush
@section('content')

    <div class="breadcrumb align-items-center">
        <h1 class="mr-2">Platformlar</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{$dataTable->table(['class' => 'table table-bordered table-hover w-100'])}}
                    </div>

                </div>
            </div>


        </div>
    </div>

    <!-- end of main-content -->

@endsection
