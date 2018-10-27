<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <title>@if(isset($page_title)){{$page_title}} | @endif {{ config('app.name', 'App') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->

    <!-- Stylesheets -->
    @yield('styles')
    <!-- Fonts -->
    @include('vibrant::layouts.partials._sharedFonts')
    @yield('fonts')
    <!-- Handle Legacy Browsers -->
    @include('vibrant::layouts.partials._legacyBrowsers')
    <!-- Top and Deferred Scripts -->
    @yield('topJs')
</head>
<body class="@yield('body_classes')" @yield('body_attributes')>
    <!-- Browse happy notice -->
    @include('vibrant::layouts.partials._browseHappy')
    <!-- Page -->
    @yield('content')
    <!-- Plugins -->
    @yield('plugins')
    <!-- Common scripts -->
    @yield('scripts')
</body>
</html>
