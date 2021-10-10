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
    <link rel="stylesheet" href="/template/dist-assets/css/plugins/datatables.min.css" />
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


<script>
    $( document ).ready(function() {

    });
</script>

@stack('scripts')

</body>

</html>
