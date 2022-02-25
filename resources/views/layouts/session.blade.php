<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta.title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/template/dist-assets/css/themes/lite-purple.min.css') }}">
</head>
@yield('content')
<script src="{{asset('storage/template/dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('storage/template/dist-assets/js/plugins/laravel_ajax.js')}}"></script>
