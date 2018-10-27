@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp
@push('framework')
    <script type="text/javascript" src="//unpkg.com/vue{{$version}}/dist/vue.js"></script>
@endpush

