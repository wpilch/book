@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')

@section('content')
    <div class="page">
        <div class="container page-container">
            <div class="panel p-30 fadeIn-onLoad">
                <h4>Dodaj pracownika</h4>
                @VibForm($form_settings) @endVibForm
            </div>
        </div>
    </div>
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
    <!-- Your custom page scripts here! -->
@endsection


