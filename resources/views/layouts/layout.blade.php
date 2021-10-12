<!DOCTYPE html>
<html lang="en" dir="">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta.title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="/template/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="/template/dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="/template/dist-assets/css/plugins/fontawesome-5.min.css" rel="stylesheet" />
    <link href="/template/dist-assets/js/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/template/dist-assets/css/plugins/datatables.min.css" rel="stylesheet" />

    <style rel="stylesheet">
        .dt-buttons{
            float: left !important;
            margin-bottom: 1rem !important;
            margin-left: 2px;
        }
        td{
            vertical-align: middle !important;
        }
        * {
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
        }

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
        .dataTables_wrapper{
            padding: 0 !important;
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
<script src="/template/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script src="/template/dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
<script src="/template/dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/template/dist-assets/js/scripts/script.min.js"></script>
<script src="/template/dist-assets/js/scripts/sidebar.large.script.min.js"></script>
<script src="/template/dist-assets/js/scripts/customizer.script.min.js"></script>
<script src="/template/dist-assets/js/plugins/laravel_ajax.js"></script>
<script src="/template/dist-assets/js/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="/template/dist-assets/js/plugins/datatables.min.js"></script>
<script src="/template/dist-assets/js/scripts/datatables.script.js"></script>
<script src="/template/dist-assets/js/scripts/customizer.script.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="/template/dist-assets/js/scripts/tooltip.script.min.js"></script>
<script src="/template/dist-assets/js/plugins/jquery-json-form-binding.js"></script>


<script>
    $( document ).ready(function() {

    });

    $( document ).ajaxComplete(function() {
        // Required for Bootstrap tooltips in DataTables
        $('[data-toggle="tooltip"]').tooltip({
            "html": true
        });

        let table = $('.dataTable').DataTable();
        $('.dataTable tbody').on( 'click', 'a.edit', function () {
            let properties = table.row($(this).parents('tr')).data();
            document.location.href = properties.urls.edit;
        } );

        $('.dataTable tbody').on( 'click', 'a.destroy', function () {
            let properties = table.row($(this).parents('tr')).data();
            console.log(properties.urls.destroy);
        } );

    });
</script>

@stack('scripts')

</body>

</html>
