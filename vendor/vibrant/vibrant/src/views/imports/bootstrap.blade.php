@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp

@bring('jquery@3.3.1')
@bring('popper@1.14.0')
@push('framework')
    <script type="text/javascript" src="https://unpkg.com/bootstrap{{$version}}/dist/js/bootstrap.min.js"></script>
@endpush
@bring('bootstrap_style@4.1.1')

