@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@bring('jquery@3.3.1')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker{{$version}}/css/datepicker.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker{{$version}}/js/datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker{{$version}}/js/i18n/datepicker.en.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker{{$version}}/js/i18n/datepicker.es.min.js"></script>
@endpush
@push('scripts')
    <script>
        jQuery(document).ready( function (){
            initAirDatepicker();
        });

        function initAirDatepicker() {
            jQuery(":text").each(function (index) {
                if(jQuery(this).attr('data-plugin') === 'airDatepicker'){
                    let value = (typeof jQuery(this).attr('data-value') !== typeof undefined) ? jQuery(this).attr('data-value') : null;
                    let options = {};
                    if(value != null){
                        let date = Date.parse(value);
                        options.startDate = new Date(date);
                    }
                    jQuery(this).datepicker(options);
                }
            });
        }
    </script>
@endpush
