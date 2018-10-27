@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('codemirror@5.39.0')

@section('content')
    @include('vibrant::modules.partials._menu')
    <div class="page">
        <div class="container page-container">
            <h1 class="page-title pt-20">View Tools</h1>
            <div class="pt-30">
                <div class="panel fadeIn-onLoad">
                    <div class="panel-heading">
                        <h3 class="panel-title">HIERARCHY</h3>
                    </div>
                    <div class="panel-body">
                        <p>A simple, intuitive view hierarchy means spending less time looking for pieces of code and more time being productive.
                            We use this convention:
                        </p>
                        <h5 class="text-center">LAYOUT<i class="icon md-chevron-right strong-icon mx-15"></i>PAGE<i class="icon md-chevron-right strong-icon mx-15"></i>COMPONENTS</h5>
                        <p>
                            Generally speaking, when using laravel blade for building a website or web app you will have one general LAYOUT that is
                            common for all your pages, then each PAGE will extend this layout to incorporate specific html code and content and, if needed, page-specific scripts and styles.
                            Also each page may incorporate COMPONENTS that can be reused in other pages.
                        </p>
                        <p><span class="badge badge-lg badge-success">TIP</span>  Check out the useful templates we include in the package for each view layer.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">THE @@bring DIRECTIVE</h3>
                    </div>
                    <div class="panel-body">
                        <p>Laravel includes a very useful component system that allows code reuse throughout your projects. The vibrant package adds the
                            <span style="font-style: italic">@@bring</span> tag helper to fully maximize its benefits. </p>
                        <p>To illustrate how to handle dependencies with <span style="font-style: italic">@@bring</span> let's take the example of the bootstrap Popover component. This component depends on three plugins to work:
                            jquery, popper and, of course, bootstrap. The 'traditional way' to call these plugins (via CDN or locally) would be to include them at the main layout. Instead,
                            we will call them at the component level by using a single line of code:
                        </p>
                        <textarea class="code">@verbatim
//Shortcut to call all the required scripts and styles for the bootstrap framework
@bring('bootstrap')@endverbatim</textarea>
                        <p>Where 'bootstrap' is the name of a blade file we have created to 'bring' the plugins and dependencies when the component is used.
                            For our bootstrap Popover component example, this package import file will look similar to this:
                        </p>
                        <textarea class="code">@verbatim
//bootstrap.blade.php - Example of package file for importing the boostrap framework
@bring('jquery')
@bring('popper')
@push('framework')
    <script src="path/to/bootstrap.min.js"></script>
@endpush
@push('framework_style')
    <link rel="stylesheet" href="path/to/bootstrap.min.css"/>
@endpush@endverbatim</textarea>
                        <p>Note that each plugin has its own dependency file and that is possible and recommended to call packages inside packages. If the requested package was already asked by other component in the same page
                            it won't be requested again. Now, we just need to init our bring engine by calling the <span style="font-style: italic">@@initBring</span> at the beginning
                            of our blade view. As in the template below.
                        </p>
                        <textarea class="code">@verbatim
// A page view using @bring
@extends('your.layout.view')

@initBring
@bring('bootstrap')

@section('content')
// Your page's content here!
@endsection

@section('styles')
@stack('framework_style')
@stack('styles')
// Your page's content here!
@endsection

@section('plugins')
@stack('framework')
@stack('plugins')
// Your page's content here!
@endsection

@section('scripts')
@stack('scripts')
// Your page's content here!
@endsection@endverbatim</textarea>
                        <p>The above sections and stacks are a mandatory convention to make <span style="font-style: italic">@@bring</span> work properly.</p>
                        <p><span class="badge badge-lg badge-success">TIP</span>  Components should bring their own packages, so no need to bring those at the page level.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">PACKAGES FOLDER</h3>
                    </div>
                    <div class="panel-body">
                        <p>You can use any view folder you want for your packages files. By default, the CM will look for
                            custom packages at the path view:<br>
                            <strong style="margin-left: 30px">imports.<span style="font-style: italic">your_package</span></strong><br>
                        </p>
                        <p>To change the custom packages folder, go to the 'vibrant' file in the config folder
                            and modify the 'bring_imports_blade_path' parameter to your needs.</p>
                        <p>Similarly, you can pass the blade path of your package imports as a second parameter for <span style="font-style: italic">@@bring</span></p>
                        <textarea class="code">@verbatim
@bring('bootstrap|path=yourApp::any.blade.path')@endverbatim</textarea>
                        <p>So <span style="font-style: italic">@@bring</span> will look for the package import file at the view path: 'yourApp::any.blade.path.bootstrap'</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">WORKING WITH VERSIONS</h3>
                    </div>
                    <div class="panel-body">
                        <p>Optionally, you can pass the version parameter with <span style="font-style: italic">@@bring</span> and make it
                            available to the package view. This is useful especially when workong with cdn providers as cdnjs or unpkg.
                            For example, imagine you want to bring Vuejs accepting versions. You simply need to create the package import file as follows:
                        </p>
                        <textarea class="code">@verbatim
//vue.blade.php - Vuejs package import file implementing versions
@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework')
    <script type="text/javascript" src="https://unpkg.com/vue{{$version}}/dist/vue.js"></script>
@endpush@endverbatim</textarea>
                        <p>Note that the '$version' parameter is always set for the import view file, even if the user is not passing the parameter, so you can use it safely.
                            Now you can call the package passing the desired version with the <span style="font-style: italic">@</span> symbol.</p>
                        <textarea class="code">@verbatim
//Bring a specific version of Vuejs
@bring('vue@2.5')@endverbatim</textarea>

                    <p><span class="badge badge-lg badge-success">TIP</span>  Some of the most popular packages are included out-of-the-box,
                        so you don't need to create the import files for these. Check the list of included plugins in the 'vibrant/imports' folder.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">TURNING OFF @@bring</h3>
                    </div>
                    <div class="panel-body">
                        <p>You can easily turn-off <span style="font-style: italic">@@bring</span> If for any reason you prefer managing your dependencies and plugins differently. For this,
                            you can just remove <span style="font-style: italic">@@initBring</span> in your views or do:</p>
                        <textarea class="code">@verbatim
@initBring(['_turn_off_bring' => true])@endverbatim</textarea>
                        <p>Once you do this <span style="font-style: italic">@@bring</span> won't call any dependency anymore.</p>
                    </div>
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
