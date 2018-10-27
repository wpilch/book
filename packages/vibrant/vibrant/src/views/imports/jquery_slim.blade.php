@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework')
    <script type="text/javascript" src="//unpkg.com/jquery{{$version}}/dist/jquery.slim.min.js"></script>
@endpush
