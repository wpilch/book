@bring('vue@2.5.16')
@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework_style')
    <link rel="stylesheet" href="//unpkg.com/element-ui{{$version}}/lib/theme-chalk/index.css">
@endpush
@push('styles')
    <style>
        .el-container{
            display: -webkit-box !important;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
        }
    </style>
@endpush
@push('framework')
    <script type="text/javascript" src="//unpkg.com/element-ui{{$version}}/lib/index.js"></script>
    @switch(app()->getLocale())
        @case('en')
            <script type="text/javascript" src="//unpkg.com/element-ui{{$version}}/lib/umd/locale/en.js"></script>
        @break
        @case('es')
            <script type="text/javascript" src="//unpkg.com/element-ui{{$version}}/lib/umd/locale/es.js"></script>
        @break
        @default
            <script type="text/javascript" src="//unpkg.com/element-ui{{$version}}/lib/umd/locale/en.js"></script>
    @endswitch
@endpush
