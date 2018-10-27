@extends('vibrant::layouts.app')

@initBring
@bring('bs_theme_blueFlame')

@section('content')
    @include('vibrant::modules.partials._menu', [
        'right_spot' => '<button id="action-open-right-drawer" class="show-for-mobiles btn btn-transparent float-right mr-2"><i class="icon wb-more-horizontal"></i></button>'
    ])
    <div class="page">
        <div class="container page-container">
            @include('vibrant::tools.headers._deskHeaderNoPkg', [
                'page_title' => ucfirst(__('vibrant::vibrant.components'))
            ])
            @include('vibrant::app.ComponentManager', ['components_by_type' => $components_by_type, 'components_json' => $components_json, 'components_paths_json' => $components_paths_json])
        </div>
    </div>
@endsection

@section('styles')
    @stack('framework_style')
    @stack('styles')
@endsection

@section('plugins')
    @stack('framework')
    @stack('plugins')
@endsection

@section('scripts')
    @stack('scripts')
@endsection
