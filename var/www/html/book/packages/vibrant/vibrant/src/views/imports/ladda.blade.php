@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda{{$version}}/ladda-themeless.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Ladda{{$version}}/spin.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Ladda{{$version}}/ladda.min.js"></script>
@endpush

