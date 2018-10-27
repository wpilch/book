@bring('vibrant_bootstrap')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>
@endpush
@push('scripts')
    <script>
        jQuery(document).ready( function (){
            initBSwitch();
        });

        function initBSwitch() {
            jQuery(":checkbox").each(function (index) {
                if(jQuery(this).attr('data-plugin') === 'bSwitch'){
                    jQuery(this).bootstrapSwitch();
                }
            });
        }
    </script>
@endpush

