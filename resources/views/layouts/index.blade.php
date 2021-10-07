<!DOCTYPE html>
<html lang="en" dir="">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('meta.title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="/template/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="/template/dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <style>
        * {
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
        }
    </style>
</head>

<body class="text-left">

<div class="app-admin-wrap layout-sidebar-large">
    <x-layout.header/>

    <x-layout.left-side/>

    @yield('content')

</div>
<script src="/template/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script src="/template/dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
<script src="/template/dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/template/dist-assets/js/scripts/script.min.js"></script>
<script src="/template/dist-assets/js/scripts/sidebar.large.script.min.js"></script>
<script src="/template/dist-assets/js/scripts/customizer.script.min.js"></script>
</body>

</html>
