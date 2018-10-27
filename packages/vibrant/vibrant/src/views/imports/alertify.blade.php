@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('plugins')
    <script type="text/javascript" src="//unpkg.com/alertify.js{{$version}}/dist/js/alertify.js"></script>
@endpush
