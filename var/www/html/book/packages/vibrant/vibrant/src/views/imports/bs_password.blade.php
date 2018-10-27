@php
    $version = (!empty($version)) ? '@'.$version : '';
@endphp

@bring('vibrant_bootstrap')
@push('scripts')
    <script type="text/javascript" src="//unpkg.com/bootstrap-show-password{{$version}}/bootstrap-show-password.min.js"></script>
@endpush

