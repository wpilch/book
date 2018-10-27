@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@bring('vibrant_bootstrap')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider{{$version}}/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider{{$version}}/css/ion.rangeSlider.skinHTML5.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider{{$version}}/js/ion.rangeSlider.min.js"></script>
@endpush
@push('scripts')
    <script>
        jQuery(document).ready( function (){
            initRangeSlider();
        });

        function initRangeSlider() {
            jQuery(":text").each(function (index) {
                if(jQuery(this).attr('data-plugin') === 'rangeSlider'){
                    jQuery(this).ionRangeSlider();
                }
            });
        }
    </script>
@endpush
