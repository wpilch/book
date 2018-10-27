@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework')
    <script type="text/javascript" src="//unpkg.com/popper.js{{$version}}/dist/umd/popper.min.js"></script>
@endpush
