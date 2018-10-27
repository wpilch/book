@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework')
    <script type="text/javascript" src="//unpkg.com/jquery{{$version}}/dist/jquery.min.js"></script>
@endpush
