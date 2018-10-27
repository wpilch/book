@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@bring('vibrant_bootstrap')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/bootstrap-table.min.css">
    <!-- Sticky Header -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/extensions/sticky-header/bootstrap-table-sticky-header.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/bootstrap-table.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <!-- Export -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/extensions/export/bootstrap-table-export.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/hhurz/tableExport.jquery.plugin/master/libs/js-xlsx/xlsx.core.min.js"></script>
    <!-- Sticky Header -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script>
    <!-- Locale -->
    @switch(app()->getLocale())
        @case('en')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/locale/bootstrap-table-en-US.min.js"></script>
        @break
        @case('es')
        <script type="text/javascript" src="{{asset('vendor/vibrant/vibrant/global/vendor/bootstrap-table/locale/bootstrap-table-es-CUSTOM.js')}}"></script>
        @break
        @default
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table{{$version}}/locale/bootstrap-table-en-US.min.js"></script>
    @endswitch

@endpush

