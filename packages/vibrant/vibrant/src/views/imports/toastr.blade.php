@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js{{$version}}/toastr.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js{{$version}}/toastr.min.js"></script>
@endpush

