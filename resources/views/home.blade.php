@extends('layouts.vibrant')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('vibrant_utilities')

@section('content')


                @VibTable($table_settings)

                @endVibTable

@endsection

@section('styles')
    @stack('framework_style')
    @stack('styles')
    <!-- Your custom styles here! -->
@endsection

@section('plugins')
    @stack('framework')
    @stack('plugins')
    <!-- Your custom plugins here! -->
@endsection

@section('scripts')
    @stack('scripts')
@endsection
