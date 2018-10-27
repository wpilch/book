@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp

@bring('vue@2.5.16')
@bring('codemirror@5.39.0')
@push('plugins')
    <script type="text/javascript" src="//unpkg.com/vue-codemirror{{$version}}/dist/vue-codemirror.js"></script>
@endpush
