<!DOCTYPE html>
<html lang="en" dir="">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta.title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/plugins/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/plugins/fontawesome-5.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('storage/template/dist-assets/js/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/plugins/datatables.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('storage/template/dist-assets/js/plugins/switch/css/bootstrap4-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/plugins/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/js/plugins/datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <style rel="stylesheet">
        .dt-buttons {
            float: left !important;
            margin-bottom: 1rem !important;
            margin-left: 2px;
        }

        td {
            vertical-align: middle !important;
        }


        .nav-tabs .nav-item .nav-link{padding: .5rem !important;}
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da !important;
        }

        .select2-container .select2-selection--single {
            height: calc(1.9695rem + 2px) !important;
            background-color: #f8f9fa;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(1.9695rem + 2px) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.9695rem + 2px) !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #663399;
            color: white;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple{
            color: #665c70;
            background-color: #fff;
            border-color: #a679d2;
            box-shadow: 0 0 0 0.2rem rgb(102 51 153 / 25%);
        }
        .select2-container--default .select2-selection--multiple{
            outline: initial !important;
            background: #f8f9fa;
            border: 1px solid #ced4da;
            color: #47404f;
        }


        .dropdown-item:hover {
            color: #fff;
            text-decoration: none;
            background-color: #663399;
        }

        :focus-visible {
            color: #665c70;
            background-color: #fff;
            border-color: #a679d2;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgb(102 51 153 / 25%);
        }


        .layout-sidebar-large .sidebar-left-secondary .childNav li.nav-item a:hover {
            background: #663399;
        }

        .layout-sidebar-large .sidebar-left-secondary .childNav li.nav-item :hover {
            color: #fff;
        }

        .layout-sidebar-large .sidebar-left-secondary .childNav li.nav-item :hover i.nav-icon {
            color: #fff;
        }

        .dataTables_wrapper {
            padding: 0 !important;
        }


        table.dataTable {
            border-collapse: collapse !important;
        }
        .data_table_toolbar{
            clear: both;
        }
        select.form-control {
            -webkit-appearance: button !important;
        }

        .tab-content{padding-left: 0!important; padding-right: 0!important;}

        .btn-group-xs>.btn, .btn-xs{
            padding: .4rem .4rem .25rem .4rem !important;
        }
        .toggle.btn-xs{
            min-width: 4.5rem !important;
        }
    </style>
</head>

<body class="text-left">

<div class="app-admin-wrap layout-sidebar-large">
    <x-layout.header/>

    <x-layout.left-side/>

    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">

            @if(session()->has('alert'))
                <x-alert :type="session()->get('alertType')" :message="session()->get('alert')"/>
            @endif

            @yield('content')

        </div>

        <x-layout.footer/>

    </div>

</div>

<script src="{{asset('storage/template/dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/script.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/sidebar.large.script.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/sidebar.script.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/laravel_ajax.js')}}"></script>


<script src="{{asset('storage/template/dist-assets/js/plugins/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/datatables.script.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/customizer.script.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/scripts/tooltip.script.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/jquery-json-form-binding.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/switch/js/bootstrap4-toggle.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/toastr.min.js')}}"></script>

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script src="{{ asset('storage/template/dist-assets/js/plugins/echarts.min.js') }}"></script>
<script src="{{ asset('storage/template/dist-assets/js/charts.js') }}"></script>

<script src="{{ asset('storage/template/dist-assets/js/plugins/datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('storage/template/dist-assets/js/plugins/datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('storage/template/dist-assets/js/plugins/datepicker/dist/locales/bootstrap-datepicker.tr.min.js') }}"></script>


<script>

    function toaster(type, message) {
        toastr.success(message, {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3
        });
    }
    function toasterError(message) {
        toastr.error(message, {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3
        });
    }

    $(document).ready(function () {

        /*
        $('button#scrape_product').click(function () {
            let data;
            data = new FormData();
            data.append( 'scrape_url', $( '#scrape_url' ).val() );
            console.log(data);
            laravel.ajax.send({
                url: '{{route('products.scrape')}}',
                data:data,
                type: 'POST',
                processData: false,
                contentType: false,
            });
        });
        */


    });

    $(document).ajaxComplete(function () {
        // Required for Bootstrap tooltips in DataTables
        $('[data-toggle="tooltip"]').tooltip({
            "html": true
        });

        let table = $('.dataTable').DataTable();
        $('.dataTable tbody').on('click', 'a.edit', function (event) {
            event.stopImmediatePropagation();
            let properties = table.row($(this).parents('tr')).data();
            document.location.href = properties.urls.edit;
        });

        $('.dataTable tbody').on('click', 'a.destroy', function (event) {
            event.stopImmediatePropagation();
            $(this).parents('tr').find('button.destroy').removeClass('d-none');
            $(this).addClass('d-none');
        });

        $('.dataTable tbody').on('click', 'button.destroy', function (event) {
            event.stopImmediatePropagation();
            let properties = table.row($(this).parents('tr')).data();
            laravel.ajax.send({
                url: properties.urls.destroy,
                type: 'DELETE',
                success: function (payload) {
                    table.draw();
                    toaster('success', 'Silindi.');
                }

            });
        });

        $('#datepicker_product_price_list').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "tr"
        });

        $('.switch-size').bootstrapToggle();
        $( ".switch-size" ).on( "change", function(event) {
            event.stopImmediatePropagation();
            let state = $(this).prop('checked');
            let product_id = $(this).data('content');
            let data;
            data = new FormData();
            data.append('productId', product_id);
            data.append('status', state);
            laravel.ajax.send({
                url: '{{route('products.updateStatus')}}',
                data: data,
                type: 'POST',
                processData: false,
                contentType: false,
                async: true,
                success: function (payload) {
                    let stateMsg = state === true ? 'aktif' : 'pasif';
                    toaster('success', 'Fiyat takibi <strong>' + stateMsg + '</strong> hale getirildi.');
                }

            });
        });


    });
</script>
@stack('scripts')

<div id='modal_section'>
    @yield('modal')
</div>

</body>

</html>
