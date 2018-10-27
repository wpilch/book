@extends('vibrant::layouts.barebone')

@initBring
<!--- Bring any package you need for your page's grid and layout here.
For example:
@bring('bootstrap@4.1.1')
Tip: Components may bring their own packages, so no need to bring those.
-->

@section('content')
    <!-- Your page's content here! -->
@endsection

@section('styles')
    @stack('framework_style')
    @stack('styles')
    <!-- Your page's custom styles here! -->
@endsection

@section('plugins')
    @stack('framework')
    @stack('plugins')
    <!-- Your page's custom plugins here! -->
@endsection

@section('scripts')
    @stack('scripts')
    <!-- Your page's custom scripts here! -->
@endsection
