@extends('vibrant::layouts.app')

@initBring
@bring('bs_theme_blueFlame')

@section('content')

    <div class="page">
        <div class="container page-container">
        @include('vibrant::tools.headers._deskHeaderNoPkg', [
            'page_title' => ucfirst(__('vibrant::vibrant.packages')),
            'ignore_resource' => true
        ])

        <div class="container px-0">
            <div class="row">
                <div class="col-lg-6 col-xl-4">
                    @component('vibrant::components.toolkit.packageCard', [
                        'url' => url('/backend/persons/crud'),
                        'name' => 'Książka adresowa',
                        'description' => 'CRUD',
                        'icon' => 'md-group',
                        'bg_image' => null,
                        'overlay_color' => '111, 151, 67',
                        'info_tag' => 'v 1.0'
                    ])
                    @endcomponent
                </div>
                @foreach($packages as $package)
                    @php
                    $url = (isset($package['settings']['route'])) ? route($package['settings']['route']) : route("backend.".$package['name']);
                    $name_lang = (isset($package['settings']['name_lang'])) ? __($package['settings']['name_lang']) :  __('vib'.ucfirst($package['name'])."::".$package['name'].".package_name");
                    $description_lang = (isset($package['settings']['description_lang'])) ? __($package['settings']['description_lang']) :  __('vib'.ucfirst($package['name'])."::".$package['name'].".package_description");
                    $icon = (isset($package['settings']['icon'])) ? $package['settings']['icon'] : '';
                    $bg_image = (isset($package['settings']['bg_image'])) ? $package['settings']['bg_image'] : '';
                    $overlay_color = (isset($package['settings']['overlay_color'])) ? $package['settings']['overlay_color'] : '';
                    @endphp
                    <div class="col-lg-6 col-xl-4">
                        @component('vibrant::components.toolkit.packageCard', [
                            'url' => $url,
                            'name' => $name_lang,
                            'description' => $description_lang,
                            'icon' => $icon,
                            'bg_image' => $bg_image,
                            'overlay_color' => $overlay_color,
                            'info_tag' => 'v '.$package['version']
                        ])
                        @endcomponent
                    </div>
                @endforeach
            </div>
        </div>
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

