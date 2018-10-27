@bring('bootstrap@4.1.1')
@php
    $version = (!empty($version)) ? '/'.$version : '/4.0.6-rc.1';
@endphp
@push('framework_style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2{{$version}}/css/select2.min.css" rel="stylesheet" />
@endpush
@push('plugins')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2{{$version}}/js/select2.min.js"></script>
@endpush

