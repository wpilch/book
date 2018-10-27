@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp

@push('framework_style')
    <link rel="stylesheet" href="//unpkg.com/bootstrap{{$version}}/dist/css/bootstrap.min.css">
@endpush

