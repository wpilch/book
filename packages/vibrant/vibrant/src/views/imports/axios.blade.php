@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('plugins')
    <script type="text/javascript" src="//unpkg.com/axios{{$version}}/dist/axios.min.js"></script>
@endpush

